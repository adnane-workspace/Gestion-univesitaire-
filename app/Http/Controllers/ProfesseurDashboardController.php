<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Module;
use App\Models\Schedule;
use App\Models\Grade;
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
        $schedulesCount = $professor->schedules()->whereDate('date', now())->count();
        $studentsCount = Student::whereHas('grades.moduleElement.module', function($q) use ($professor) {
            $q->whereHas('professors', function($pq) use ($professor) {
                $pq->where('professors.id', $professor->id);
            });
        })->distinct()->count();

        return view('professeur.dashboard', compact('professor', 'modules', 'schedulesCount', 'studentsCount'));
    }

    public function modules()
    {
        $professor = Auth::user()->professor;
        $modules = $professor->modules()->with(['filiere', 'moduleElements'])->get();
        return view('professeur.modules', compact('modules'));
    }

    public function grades(Request $request)
    {
        $professor = Auth::user()->professor;
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

    public function schedule()
    {
        $professor = Auth::user()->professor;
        $schedules = $professor->schedules()
            ->with(['module', 'room'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
            
        return view('professeur.schedule', compact('schedules'));
    }
}
