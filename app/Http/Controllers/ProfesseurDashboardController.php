<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Module;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Absence;
use App\Models\Student;
use App\Models\ModuleElement;
use Illuminate\Support\Facades\Auth;

class ProfesseurDashboardController extends Controller
{
    public function index()
    {
        $professor = Auth::user()->professor;
        
        if (!$professor) {
            return redirect()->route('login')->with('error', 'Profil professeur non trouvé.');
        }

        $modules = $professor->modules()->with('filiere')->get();
        $todayDay = now()->locale('fr')->isoFormat('dddd');
        $todaySchedules = $professor->schedules()
            ->with(['module', 'room'])
            ->where(function ($query) use ($todayDay) {
                $query->whereDate('date', today())
                    ->orWhere(function ($query) use ($todayDay) {
                        $query->whereNull('date')
                            ->where('day', ucfirst($todayDay));
                    });
            })
            ->orderBy('start_time')
            ->get();

        $schedulesCount = $todaySchedules->count();
        $studentsCount = Student::whereIn('filiere_id', $modules->pluck('filiere_id')->filter()->unique())
            ->distinct()
            ->count();

        $absencesCount = Absence::whereHas('schedule', function ($q) use ($professor) {
            $q->where('professor_id', $professor->id);
        })->whereDate('date', now())->count();

        return view('professeur.dashboard', compact('professor', 'modules', 'todaySchedules', 'schedulesCount', 'studentsCount', 'absencesCount'));
    }

    public function modules()
    {
        $professor = Auth::user()->professor;
        if (!$professor) {
            return redirect()->route('login')->with('error', 'Profil professeur non trouvé.');
        }
        $modules = $professor->modules()->with(['filiere', 'moduleElements'])->get();
        return view('professeur.modules', compact('modules'));
    }

    public function grades(Request $request)
    {
        $professor = Auth::user()->professor;
        if (!$professor) {
            return redirect()->route('login')->with('error', 'Profil professeur non trouvé.');
        }
        $modules = $professor->modules()->with('moduleElements')->get();
        
        $selectedModuleId = $request->input('module_id');
        $selectedElementId = $request->input('element_id');
        
        $students = [];
        if ($selectedElementId) {
            // Pour simplifier, on prend tous les étudiants car le lien direct étudiant-module passe par les notes/inscriptions
            // Dans ce système simplifié, on peut filtrer par filière du module
            $module = Module::find($selectedModuleId);
            if ($module) {
                $students = Student::all(); // On pourrait filtrer par inscription si on avait gardé Enrollments
                // Mais ici on va juste permettre la saisie pour n'importe quel étudiant pour l'exemple
            }
        }

        return view('professeur.grades', compact('modules', 'students', 'selectedModuleId', 'selectedElementId'));
    }

    public function storeGrades(Request $request)
    {
        $request->validate([
            'element_id' => 'required|exists:module_elements,id',
            'grades' => 'required|array',
            'grades.*' => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($request->grades as $studentId => $value) {
            if ($value !== null) {
                Grade::updateOrCreate(
                    ['student_id' => $studentId, 'module_element_id' => $request->element_id],
                    ['score' => $value, 'academic_year' => '2024-2025', 'session' => 'normal']
                );
            }
        }

        return back()->with('success', 'Notes enregistrées avec succès.');
    }

    public function absences(Request $request)
    {
        $professor = Auth::user()->professor;
        if (!$professor) {
            return redirect()->route('login')->with('error', 'Profil professeur non trouvé.');
        }

        $schedules = $professor->schedules()->with(['module', 'room'])->orderBy('date')->orderBy('start_time')->get();
        $selectedScheduleId = $request->input('schedule_id');

        // Auto-select first available schedule when none is provided
        if (!$selectedScheduleId && $schedules->isNotEmpty()) {
            $selectedScheduleId = $schedules->first()->id;
        }

        $schedule = null;
        $students = collect();
        $absences = collect();

        if ($selectedScheduleId) {
            $schedule = $professor->schedules()->where('id', $selectedScheduleId)->with('module')->first();
            if ($schedule && $schedule->module) {
                $students = Student::with('filiere')
                    ->where('filiere_id', $schedule->module->filiere_id)
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get();

                $absences = Absence::where('schedule_id', $selectedScheduleId)->get()->keyBy('student_id');
            }
        }

        return view('professeur.absences', compact('schedules', 'selectedScheduleId', 'students', 'schedule', 'absences'));
    }

    public function storeAbsences(Request $request)
    {
        $professor = Auth::user()->professor;
        if (!$professor) {
            return redirect()->route('login')->with('error', 'Profil professeur non trouvé.');
        }

        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'absent' => 'array',
            'absent.*' => 'in:1',
            'reason' => 'array',
            'reason.*' => 'nullable|string|max:255',
            'excused' => 'array',
            'excused.*' => 'nullable|in:1',
        ]);

        if (!$professor->schedules()->where('id', $request->schedule_id)->exists()) {
            abort(403, 'Accès non autorisé.');
        }

        $schedule = Schedule::find($request->schedule_id);
        if (!$schedule) {
            return back()->with('error', 'Séance introuvable.');
        }

        $selectedAbsences = $request->input('absent', []);
        $reasons = $request->input('reason', []);
        $excused = $request->input('excused', []);

        foreach ($selectedAbsences as $studentId => $value) {
            Absence::updateOrCreate(
                ['student_id' => $studentId, 'schedule_id' => $schedule->id],
                [
                    'date' => $schedule->date ?? now()->toDateString(),
                    'reason' => $reasons[$studentId] ?? null,
                    'excused' => isset($excused[$studentId]) ? true : false,
                ]
            );
        }

        Absence::where('schedule_id', $schedule->id)
            ->whereNotIn('student_id', array_keys($selectedAbsences))
            ->delete();

        return back()->with('success', 'Absences mises à jour avec succès.');
    }

    public function schedule()
    {
        $professor = Auth::user()->professor;
        if (!$professor) {
            return redirect()->route('login')->with('error', 'Profil professeur non trouvé.');
        }
        $schedules = $professor->schedules()
            ->with(['module', 'room'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
            
        return view('professeur.schedule', compact('schedules'));
    }
}
