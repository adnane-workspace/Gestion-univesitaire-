<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Absence;

class StudentApiController extends Controller
{
    public function grades(Request $request)
    {
        $student = auth('api')->user()->student;

        if (! $student) {
            return response()->json(['grades' => []]);
        }

        $grades = $student->grades()->with('moduleElement')->get();

        return response()->json(['grades' => $grades]);
    }

    public function gpa(Request $request)
    {
        $student = auth('api')->user()->student;
        if (! $student) {
            return response()->json(['gpa' => 0]);
        }

        return response()->json(['gpa' => $student->calculateGPA()]);
    }

    public function schedule(Request $request)
    {
        $student = auth('api')->user()->student;
        if (! $student) {
            return response()->json(['schedule' => []]);
        }

        $schedules = Schedule::with(['module', 'room', 'professor'])
            ->whereHas('module', function ($q) use ($student) {
                $q->where('filiere_id', $student->filiere_id);
            })->get();

        return response()->json(['schedule' => $schedules]);
    }

    public function absences(Request $request)
    {
        $student = auth('api')->user()->student;
        if (! $student) {
            return response()->json(['absences' => []]);
        }

        $absences = Absence::where('student_id', $student->id)->get();

        return response()->json(['absences' => $absences]);
    }
}
