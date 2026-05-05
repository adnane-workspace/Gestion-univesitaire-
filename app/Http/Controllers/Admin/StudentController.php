<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Filiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user'])->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $filieres = Filiere::where('is_active', true)->get();
        return view('admin.students.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'student_id_number' => 'required|string|unique:students,student_id_number',
            'address' => 'nullable|string',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => 'etudiant',
        ]);

        // Créer l'étudiant
        $student = Student::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'student_id_number' => $validated['student_id_number'],
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant créé avec succès. Mot de passe par défaut : password');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $filieres = Filiere::where('is_active', true)->get();
        return view('admin.students.edit', compact('student', 'filieres'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        $student->update($validated);
        $student->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant mis à jour avec succès');
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant supprimé avec succès');
    }
}
