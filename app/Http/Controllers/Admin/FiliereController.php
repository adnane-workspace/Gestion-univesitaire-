<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::withCount('modules')->latest()->paginate(10);
        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('admin.filieres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:filieres,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_years' => 'required|integer|min:1|max:6',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Filiere::create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration_years' => $validated['duration_years'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière créée avec succès');
    }

    public function show(Filiere $filiere)
    {
        $filiere->load('modules');
        return view('admin.filieres.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:filieres,code,' . $filiere->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_years' => 'required|integer|min:1|max:6',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $filiere->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration_years' => $validated['duration_years'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière mise à jour avec succès');
    }

    public function destroy(Filiere $filiere)
    {
        if ($filiere->modules()->count() > 0 || $filiere->enrollments()->count() > 0) {
            return redirect()->route('admin.filieres.index')
                ->with('error', 'Impossible de supprimer cette filière car elle contient des modules ou des inscriptions');
        }

        $filiere->delete();
        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière supprimée avec succès');
    }
}
