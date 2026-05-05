@extends('layouts.admin-layout')

@section('title', 'Modifier le Module')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.modules.index') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Modifier le Module</h1>
        <p class="text-slate-500 mt-1">Éditer les informations du module : {{ $module->name }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.modules.update', $module) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nom du module</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $module->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-slate-700 mb-2">Code</label>
                    <input type="text" id="code" name="code" value="{{ old('code', $module->code) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="filiere_id" class="block text-sm font-medium text-slate-700 mb-2">Filière</label>
                    <select id="filiere_id" name="filiere_id" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                        <option value="">Sélectionner une filière</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ old('filiere_id', $module->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                {{ $filiere->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('filiere_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semester" class="block text-sm font-medium text-slate-700 mb-2">Semestre</label>
                    <select id="semester" name="semester" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('semester', $module->semester) == $i ? 'selected' : '' }}>Semestre {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $module->is_active) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Module actif</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="credits" class="block text-sm font-medium text-slate-700 mb-2">Nombre de crédits</label>
                    <input type="number" id="credits" name="credits" value="{{ old('credits', $module->credits) }}" required min="1" max="30"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('credits')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hours" class="block text-sm font-medium text-slate-700 mb-2">Volume horaire (H)</label>
                    <input type="number" id="hours" name="hours" value="{{ old('hours', $module->hours) }}" required min="1" max="200"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('hours')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description / Objectifs</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">{{ old('description', $module->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow-md transition-all">
                    Mettre à jour le module
                </button>
                <a href="{{ route('admin.modules.index') }}" class="text-slate-600 hover:text-slate-800 px-6 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
