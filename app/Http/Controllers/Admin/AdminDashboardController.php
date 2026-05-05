<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Filiere;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students_count' => Student::count(),
            'students_growth' => $this->calculateGrowth(Student::class),
            'professors_count' => Professor::count(),
            'filieres_count' => Filiere::where('is_active', true)->count(),
            'rooms_available' => Room::where('is_available', true)->count(),
        ];

        $recent_students = Student::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_students'));
    }

    private function calculateGrowth($model)
    {
        $currentMonth = $model::whereMonth('created_at', now()->month)->count();
        $lastMonth = $model::whereMonth('created_at', now()->subMonth()->month)->count();
        
        if ($lastMonth == 0) return 0;
        return round((($currentMonth - $lastMonth) / $lastMonth) * 100);
    }
}
