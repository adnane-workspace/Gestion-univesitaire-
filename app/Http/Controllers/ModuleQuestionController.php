<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Module;
use App\Models\QcmAttempt;
use App\Models\QcmAttemptAnswer;
use App\Models\Question;
use App\Services\AiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModuleQuestionController extends Controller
{
    public function generate(Module $module, Request $request, AiClient $ai)
    {
        $request->validate([
            'num' => 'nullable|integer|min:1|max:20',
            'difficulty' => 'nullable|string|max:50',
        ]);

        $professor = Auth::user()->professor;
        if (!$professor || !$professor->modules()->where('modules.id', $module->id)->exists()) {
            abort(403, 'Accès non autorisé au module.');
        }

        $count = $request->input('num', 10);
        $difficulty = $request->input('difficulty', 'moyen');

        try {
            $prompt = $this->buildPrompt($module, $count, $difficulty);
            $response = $ai->generateQcm($prompt);
            $parsed = $ai->parseGeneratedJson($response);

            if (empty($parsed['questions']) || !is_array($parsed['questions'])) {
                return response()->json(['error' => 'La réponse de l’IA est incorrecte ou ne contient pas de questions.'], 500);
            }

            $this->storeParsedQuestions($module, $parsed);

            return response()->json(['ok' => true, 'redirect' => route('professeur.modules.qcm', ['module' => $module->id])]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            Log::warning('AI generation failed for module '.$module->id.': '.$msg);

            // Auto-fallback conditions: local dev with AI_MOCK enabled OR common API messages about credits/permission
            $shouldFallback = (app()->environment('local') && env('AI_MOCK', false));
            $lower = strtolower($msg);
            if (stripos($lower, 'credit') !== false || stripos($lower, 'no credits') !== false || stripos($lower, 'does not have permission') !== false || stripos($lower, "doesn't have any credits") !== false || stripos($lower, 'does not have permission') !== false) {
                $shouldFallback = true;
            }

            if ($shouldFallback) {
                $parsed = $this->buildMockResponse($module, $count);
                $this->storeParsedQuestions($module, $parsed);
                return response()->json(['ok' => true, 'redirect' => route('professeur.modules.qcm', ['module' => $module->id]), 'mock' => true]);
            }

            return response()->json(['error' => 'Erreur lors de la génération du QCM : ' . $e->getMessage()], 500);
        }
    }

    public function show(Module $module)
    {
        $professor = Auth::user()->professor;
        if (!$professor || !$professor->modules()->where('modules.id', $module->id)->exists()) {
            abort(403, 'Accès non autorisé au module.');
        }

        $questions = $module->questions()->with('choices')->get();

        return view('professeur.module_qcm', compact('module', 'questions'));
    }

    public function attempts(Module $module)
    {
        $professor = Auth::user()->professor;
        if (!$professor || !$professor->modules()->where('modules.id', $module->id)->exists()) {
            abort(403, 'Accès non autorisé au module.');
        }

        $attempts = QcmAttempt::where('module_id', $module->id)
            ->with('student')
            ->orderByDesc('created_at')
            ->get();

        return view('professeur.module_qcm_attempts', compact('module', 'attempts'));
    }

    public function showAttempt(Module $module, QcmAttempt $attempt)
    {
        $professor = Auth::user()->professor;
        if (!$professor || !$professor->modules()->where('modules.id', $module->id)->exists()) {
            abort(403, 'Accès non autorisé au module.');
        }

        if ($attempt->module_id !== $module->id) {
            abort(404, 'Tentative introuvable pour ce module.');
        }

        $attempt->load(['student', 'answers.question.choices', 'answers.selectedChoice']);

        return view('professeur.module_qcm_attempt_show', compact('module', 'attempt'));
    }

    public function studentQcm(Module $module)
    {
        $student = Auth::user()->student;
        if (!$student || $student->filiere_id !== $module->filiere_id) {
            abort(403, 'Accès non autorisé au module.');
        }

        $questions = $module->questions()->with('choices')->get();

        return view('etudiant.module_qcm', compact('module', 'questions'));
    }

    public function submitStudentQcm(Request $request, Module $module)
    {
        $student = Auth::user()->student;
        if (!$student || $student->filiere_id !== $module->filiere_id) {
            abort(403, 'Accès non autorisé au module.');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|integer|exists:choices,id',
        ]);

        $questions = $module->questions()->with('choices')->get();
        if ($questions->isEmpty()) {
            return redirect()->route('etudiant.modules.qcm', ['module' => $module->id])
                ->with('error', 'Aucun QCM disponible pour ce module.');
        }

        $answers = $request->input('answers', []);
        $questionCount = $questions->count();
        $correctCount = 0;

        DB::transaction(function () use ($student, $module, $questions, $answers, &$correctCount, $questionCount) {
            $attempt = QcmAttempt::create([
                'student_id' => $student->id,
                'module_id' => $module->id,
                'score' => 0,
                'max_score' => 20,
                'correct_count' => 0,
                'question_count' => $questionCount,
            ]);

            foreach ($questions as $question) {
                $selectedChoiceId = isset($answers[$question->id]) ? intval($answers[$question->id]) : null;
                $choice = $question->choices->firstWhere('id', $selectedChoiceId);
                $isCorrect = $choice && $choice->is_correct;

                if ($isCorrect) {
                    $correctCount++;
                }

                QcmAttemptAnswer::create([
                    'qcm_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_choice_id' => $selectedChoiceId,
                    'is_correct' => $isCorrect,
                ]);
            }

            $score = $questionCount > 0 ? (int) round(($correctCount / $questionCount) * 20) : 0;
            $attempt->update([
                'score' => $score,
                'correct_count' => $correctCount,
            ]);
        });

        return redirect()->route('etudiant.modules.qcm', ['module' => $module->id])
            ->with('success', 'Votre réponse a été enregistrée. Score : ' . $correctCount . ' / ' . $questionCount . ' (' . (int) round(($questionCount > 0 ? ($correctCount / $questionCount) * 20 : 0)) . '/20).');
    }

    protected function buildPrompt(Module $module, int $count, string $difficulty): string
    {
        $elements = $module->moduleElements()->pluck('name')->filter()->implode(', ');
        $description = trim($module->description ?? '');

        return "Tu es un assistant pédagogique. Génère $count questions de révision QCM pour le module suivant. " .
            "Présente ta réponse uniquement sous forme de JSON strict. " .
            "Le format doit être : {\"questions\":[{\"question\":\"...\",\"choices\":[\"...\",...],\"correct_index\":0,\"explanation\":\"...\"}]}. " .
            "Chaque question doit avoir exactement 4 propositions. " .
            "Donne des questions claires, en français, adaptées à un niveau $difficulty.\n\n" .
            "Module: {$module->name}\n" .
            "Description: $description\n" .
            "Éléments: $elements\n\n" .
            "Réponds uniquement par le JSON demandé, sans texte supplémentaire.";
    }

    protected function storeParsedQuestions(Module $module, array $parsed): void
    {
        DB::transaction(function () use ($module, $parsed) {
            $module->questions()->where('ai_generated', true)->delete();

            foreach ($parsed['questions'] as $item) {
                if (empty($item['question']) || empty($item['choices']) || !is_array($item['choices'])) {
                    continue;
                }

                $question = Question::create([
                    'module_id' => $module->id,
                    'text' => trim($item['question']),
                    'explanation' => $item['explanation'] ?? null,
                    'difficulty' => $item['difficulty'] ?? null,
                    'ai_generated' => true,
                ]);

                $correctIndex = isset($item['correct_index']) ? intval($item['correct_index']) : null;
                foreach ($item['choices'] as $index => $choiceText) {
                    if (trim((string)$choiceText) === '') {
                        continue;
                    }

                    Choice::create([
                        'question_id' => $question->id,
                        'text' => trim($choiceText),
                        'is_correct' => $correctIndex !== null && $index === $correctIndex,
                    ]);
                }
            }
        });
    }

    protected function buildMockResponse(Module $module, int $count): array
    {
        $questions = [];
        $elements = $module->moduleElements()->pluck('name')->filter()->toArray();
        for ($i = 1; $i <= $count; $i++) {
            $el = $elements ? $elements[array_rand($elements)] : $module->name;
            $qText = "Question {$i} — Quel est le concept lié à \"{$el}\" ?";
            $choices = [
                "Réponse correcte sur {$el}",
                "Réponse distracteur A",
                "Réponse distracteur B",
                "Réponse distracteur C",
            ];
            $questions[] = [
                'question' => $qText,
                'choices' => $choices,
                'correct_index' => 0,
                'explanation' => "Explication courte sur {$el}.",
            ];
        }

        return ['questions' => $questions];
    }
}
