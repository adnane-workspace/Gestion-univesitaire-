<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $modules = $student->filiere->modules()->with('professors')->get();
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
        })->with(['module', 'room', 'professor'])->orderBy('date')->orderBy('start_time')->get();

        return view('etudiant.schedule', compact('schedules'));
    }
}
