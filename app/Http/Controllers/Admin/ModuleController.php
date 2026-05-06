<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Filiere;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with(['filiere', 'professors'])->latest()->paginate(10);
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $filieres = Filiere::where('is_active', true)->get();
        return view('admin.modules.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:modules,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:30',
            'hours' => 'required|integer|min:1|max:200',
            'semester' => 'required|integer|min:1|max:6',
            'filiere_id' => 'required|exists:filieres,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Module::create($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module créé avec succès');
    }

    public function show(Module $module)
    {
        $module->load(['filiere', 'professors']);
        return view('admin.modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        $filieres = Filiere::where('is_active', true)->get();
        return view('admin.modules.edit', compact('module', 'filieres'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:modules,code,' . $module->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:30',
            'hours' => 'required|integer|min:1|max:200',
            'semester' => 'required|integer|min:1|max:6',
            'filiere_id' => 'required|exists:filieres,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $module->update($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module mis à jour avec succès');
    }

    public function destroy(Module $module)
    {
        if ($module->professors()->count() > 0) {
            return redirect()->route('admin.modules.index')
                ->with('error', 'Impossible de supprimer ce module car il est affecté à des professeurs');
        }

        $module->delete();
        return redirect()->route('admin.modules.index')
            ->with('success', 'Module supprimé avec succès');
    }
}
