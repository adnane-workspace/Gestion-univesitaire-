<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EtudiantDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre profil étudiant n\'est pas encore configuré. Contactez l\'administration.');
        }

        return view('etudiant.dashboard', compact('student'));
    }

    public function grades()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('login')->with('error', 'Profil étudiant non trouvé.');
        }

        $grades = $student->grades()
            ->with(['moduleElement.module'])
            ->get()
            ->groupBy(function($grade) {
                return $grade->moduleElement->module->name;
            });

        return view('etudiant.grades', compact('grades'));
    }

    public function modules()
    {
        $student = Auth::user()->student;
        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre profil étudiant n\'est pas configuré.');
        }
        $modules = $student->filiere->modules()->with('professors')->withCount('questions')->get();
        return view('etudiant.modules', compact('modules'));
    }

    public function schedule()
    {
        $student = Auth::user()->student;
        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre profil étudiant n\'est pas configuré.');
        }
        $schedules = \App\Models\Schedule::whereHas('module', function($q) use ($student) {
            $q->where('filiere_id', $student->filiere_id);
        })->with(['module', 'room', 'professor'])->orderBy('day')->orderBy('start_time')->get();

        return view('etudiant.schedule', compact('schedules', 'student'));
    }

    public function bulletinPdf()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('login')->with('error', 'Profil étudiant non trouvé.');
        }

        $grades = $student->grades()->with(['moduleElement.module'])->get();
        $absences = \App\Models\Absence::where('student_id', $student->id)
            ->with(['schedule.module', 'schedule.room', 'schedule.professor'])
            ->get();
        $gpa = $student->calculateGPA();
        $logo = null;
        $logoPath = public_path('logo.png');
        if (File::exists($logoPath)) {
            $logo = base64_encode(File::get($logoPath));
        }

        $pdf = Pdf::loadView('etudiant.bulletin_pdf', compact('student', 'grades', 'absences', 'gpa', 'logo'));
        return $pdf->download('Bulletin_' . Str::slug($student->getFullNameAttribute(), '_') . '.pdf');
    }

    public function chatbotQuery(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return response()->json(['reply' => 'Profil étudiant introuvable.'], 403);
        }

        $query = strtolower($request->validate(['query' => 'required|string'])['query']);
        
        $reply = '<div class="text-center py-4">' .
                 '<span class="text-2xl block mb-2">🤔</span>' .
                 '<p class="text-sm font-bold text-slate-700 mb-1">Je n\'ai pas compris</p>' .
                 '<p class="text-[11px] text-slate-400 font-semibold">Essaie : planning, notes, moyenne ou absences</p>' .
                 '</div>';

        if (preg_match('/^(bonjour|salut|hello|hey|coucou|aide|qui es-tu|help|bonsoir|yo|commencer|start)/i', $query)) {
            $reply = '<div class="space-y-3">' .
                     '<p class="font-black text-slate-900 text-sm">Bonjour ' . e($student->first_name) . ' ! 👋</p>' .
                     '<p class="text-[13px] text-slate-600 font-medium leading-relaxed">Je peux t\'aider avec :</p>' .
                     '<div class="grid grid-cols-2 gap-2">' .
                     '<div class="p-2.5 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center gap-2">' .
                     '<span class="text-lg">📅</span>' .
                     '<div><p class="text-[11px] font-black text-indigo-700">Planning</p><p class="text-[10px] text-slate-500 font-semibold">Cours du jour</p></div>' .
                     '</div>' .
                     '<div class="p-2.5 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2">' .
                     '<span class="text-lg">📝</span>' .
                     '<div><p class="text-[11px] font-black text-emerald-700">Notes</p><p class="text-[10px] text-slate-500 font-semibold">Derniers résultats</p></div>' .
                     '</div>' .
                     '<div class="p-2.5 bg-amber-50 border border-amber-100 rounded-xl flex items-center gap-2">' .
                     '<span class="text-lg">📊</span>' .
                     '<div><p class="text-[11px] font-black text-amber-700">Moyenne</p><p class="text-[10px] text-slate-500 font-semibold">GPA</p></div>' .
                     '</div>' .
                     '<div class="p-2.5 bg-rose-50 border border-rose-100 rounded-xl flex items-center gap-2">' .
                     '<span class="text-lg">⚠️</span>' .
                     '<div><p class="text-[11px] font-black text-rose-700">Absences</p><p class="text-[10px] text-slate-500 font-semibold">Suivi</p></div>' .
                     '</div>' .
                     '</div>' .
                     '</div>';
        } elseif (preg_match('/(emploi|planning|horaire|cours|calendrier|classe|plannings|emplois|horaires|agenda|programme)/i', $query)) {
            $today = \Carbon\Carbon::now()->locale('fr')->dayName;
            $schedule = \App\Models\Schedule::whereHas('module', function ($q) use ($student) {
                $q->where('filiere_id', $student->filiere_id);
            })->where('day', ucfirst($today))->with(['module', 'room', 'professor'])->orderBy('start_time')->get();

            if ($schedule->isEmpty()) {
                $reply = '<div class="text-center py-4">' .
                         '<span class="text-2xl block mb-2">🎉</span>' .
                         '<p class="text-sm font-bold text-slate-700 mb-1">Aucun cours aujourd\'hui !</p>' .
                         '<p class="text-[11px] text-slate-400 font-semibold">Profite de ta journée libre.</p>' .
                         '</div>';
            } else {
                $lines = $schedule->map(function ($item) {
                    $startTime = \Carbon\Carbon::parse($item->start_time)->format('H:i');
                    $endTime = \Carbon\Carbon::parse($item->end_time)->format('H:i');
                    return '<div class="p-3 bg-white border border-slate-100 rounded-xl">' .
                           '<div class="flex items-center justify-between mb-1.5">' .
                           '<span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">' . e($startTime) . ' - ' . e($endTime) . '</span>' .
                           '<span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">' . e($item->room->name) . '</span>' .
                           '</div>' .
                           '<p class="text-[13px] font-bold text-slate-800">' . e($item->module->name) . '</p>' .
                           '<p class="text-[11px] font-semibold text-slate-400 mt-0.5">Pr. ' . e($item->professor->first_name) . ' ' . e($item->professor->last_name) . '</p>' .
                           '</div>';
                });
                $reply = '<div class="space-y-2">' .
                         '<p class="font-black text-slate-900 text-sm flex items-center gap-1.5">📅 Planning du jour</p>' .
                         '<div class="space-y-2">' . $lines->join('') . '</div>' .
                         '</div>';
            }
        } elseif (preg_match('/(note|notes|résultat|résultats|score|scores|bulletin|examen|examens|contrôle|contrôles|devoir|devoirs|évaluation|évaluations)/i', $query)) {
            $grades = $student->grades()->with(['moduleElement.module'])->latest()->take(5)->get();
            if ($grades->isEmpty()) {
                $reply = '<div class="text-center py-4"><p class="text-sm font-bold text-slate-400">Aucune note enregistrée.</p></div>';
            } else {
                $lines = $grades->map(function ($grade) {
                    $score = number_format($grade->score, 1);
                    $passed = $grade->score >= 10;
                    return '<div class="flex items-center justify-between p-2.5 bg-white border border-slate-100 rounded-xl">' .
                           '<div class="flex-1 min-w-0">' .
                           '<p class="text-[10px] font-bold text-slate-400 uppercase truncate">' . e($grade->moduleElement->module->name) . '</p>' .
                           '<p class="text-[13px] font-bold text-slate-700 truncate">' . e($grade->moduleElement->name) . '</p>' .
                           '</div>' .
                           '<span class="text-sm font-black ' . ($passed ? 'text-emerald-600' : 'text-rose-500') . ' ml-2">' . e($score) . '</span>' .
                           '</div>';
                });
                $reply = '<div class="space-y-2">' .
                         '<p class="font-black text-slate-900 text-sm flex items-center gap-1.5">📝 Notes récentes</p>' .
                         '<div class="space-y-1.5">' . $lines->join('') . '</div>' .
                         '</div>';
            }
        } elseif (preg_match('/(moyen|moyenne|moyennes|gpa|g.p.a)/i', $query)) {
            $gpa = $student->calculateGPA();
            $gpaFormatted = number_format($gpa, 2);
            $avg = $student->grades->avg('score') ?? 0;
            
            if ($gpa >= 14) {
                $color = 'from-emerald-500 to-emerald-600';
                $emoji = '🚀';
                $phrase = 'Excellent travail !';
            } elseif ($gpa >= 10) {
                $color = 'from-amber-500 to-amber-600';
                $emoji = '👍';
                $phrase = 'Bon travail, continue !';
            } else {
                $color = 'from-rose-500 to-rose-600';
                $emoji = '💪';
                $phrase = 'Ne lâche pas !';
            }
            
            $reply = '<div class="bg-gradient-to-br ' . $color . ' text-white p-4 rounded-xl relative overflow-hidden">' .
                     '<div class="absolute -right-4 -bottom-4 w-16 h-16 bg-white/10 rounded-full blur-lg"></div>' .
                     '<div class="relative z-10">' .
                     '<div class="flex items-center justify-between mb-2">' .
                     '<span class="text-[10px] font-bold uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded-md">Moyenne Générale</span>' .
                     '<span class="text-lg">' . $emoji . '</span>' .
                     '</div>' .
                     '<p class="text-2xl font-black">' . e($gpaFormatted) . ' <span class="text-xs font-semibold opacity-80">/ 20</span></p>' .
                     '<p class="text-[11px] font-semibold opacity-90 mt-2 border-t border-white/20 pt-2">' . $phrase . '</p>' .
                     '</div>' .
                     '</div>';
        } elseif (preg_match('/(absence|absences|manqué|retard|retards|cours manqué|cours manqués|assiduité)/i', $query)) {
            $absences = \App\Models\Absence::where('student_id', $student->id)->get();
            if ($absences->isEmpty()) {
                $reply = '<div class="text-center py-4">' .
                         '<span class="text-2xl block mb-2">⭐</span>' .
                         '<p class="text-sm font-bold text-slate-700 mb-1">Aucune absence !</p>' .
                         '<span class="inline-block text-[10px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">Assiduité parfaite</span>' .
                         '</div>';
            } else {
                $lines = $absences->map(function ($absence) {
                    $dateStr = $absence->date->format('d/m/Y');
                    $excused = $absence->excused;
                    return '<div class="p-2.5 bg-white border border-slate-100 rounded-xl">' .
                           '<div class="flex items-center justify-between mb-1">' .
                           '<span class="text-[11px] font-bold text-slate-600">📅 ' . e($dateStr) . '</span>' .
                           '<span class="text-[10px] font-bold ' . ($excused ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50') . ' px-2 py-0.5 rounded-md">' . ($excused ? 'Justifiée' : 'Non justifiée') . '</span>' .
                           '</div>' .
                           '<p class="text-[11px] text-slate-500 font-semibold">' . e($absence->reason ?? 'Non renseigné') . '</p>' .
                           '</div>';
                });
                $reply = '<div class="space-y-2">' .
                         '<p class="font-black text-slate-900 text-sm flex items-center gap-1.5">⚠️ Absences (' . $absences->count() . ')</p>' .
                         '<div class="space-y-1.5">' . $lines->join('') . '</div>' .
                         '</div>';
            }
        }

        return response()->json(['reply' => $reply]);
    }
}
