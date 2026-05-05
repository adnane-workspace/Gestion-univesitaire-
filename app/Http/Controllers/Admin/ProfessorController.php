<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::with('user')->latest()->paginate(10);
        return view('admin.professors.index', compact('professors'));
    }

    public function create()
    {
        $modules = Module::where('is_active', true)->get();
        return view('admin.professors.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'speciality' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'modules' => 'nullable|array',
            'modules.*' => 'exists:modules,id',
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => 'professeur',
        ]);

        $professor = Professor::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'speciality' => $validated['speciality'],
            'hire_date' => $validated['hire_date'],
        ]);

        if (!empty($validated['modules'])) {
            $professor->modules()->attach($validated['modules'], ['academic_year' => now()->format('Y') . '-' . (now()->format('Y') + 1)]);
        }

        return redirect()->route('admin.professors.index')
            ->with('success', 'Professeur créé avec succès. Mot de passe par défaut : password');
    }

    public function show(Professor $professor)
    {
        $professor->load('modules');
        return view('admin.professors.show', compact('professor'));
    }

    public function edit(Professor $professor)
    {
        $modules = Module::where('is_active', true)->get();
        $assignedModules = $professor->modules->pluck('id')->toArray();
        return view('admin.professors.edit', compact('professor', 'modules', 'assignedModules'));
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email,' . $professor->id,
            'phone' => 'nullable|string|max:20',
            'speciality' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'modules' => 'nullable|array',
            'modules.*' => 'exists:modules,id',
        ]);

        $professor->update($validated);
        $professor->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        $professor->modules()->detach();
        if (!empty($validated['modules'])) {
            $professor->modules()->attach($validated['modules'], ['academic_year' => now()->format('Y') . '-' . (now()->format('Y') + 1)]);
        }

        return redirect()->route('admin.professors.index')
            ->with('success', 'Professeur mis à jour avec succès');
    }

    public function destroy(Professor $professor)
    {
        $professor->user->delete();
        return redirect()->route('admin.professors.index')
            ->with('success', 'Professeur supprimé avec succès');
    }
}
