@extends('layouts.admin-layout')

@section('title', 'Nouvelle Filière')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.filieres.index') }}" class="btn btn-ghost mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Nouvelle Filière</h1>
        <p class="text-slate-500 mt-1">Ajouter une nouvelle filière de formation</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.filieres.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="input-label">Nom de la filière</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="input">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="input-label">Code (ex: SMI, SMA, SEG)</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required
                        class="input">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="duration_years" class="input-label">Durée (années)</label>
                    <select id="duration_years" name="duration_years" required
                        class="input">
                        <option value="1" {{ old('duration_years') == 1 ? 'selected' : '' }}>1 an</option>
                        <option value="2" {{ old('duration_years') == 2 ? 'selected' : '' }}>2 ans</option>
                        <option value="3" {{ old('duration_years', 3) == 3 ? 'selected' : '' }}>3 ans (Licence)</option>
                        <option value="5" {{ old('duration_years') == 5 ? 'selected' : '' }}>5 ans (Master/Ingénieur)</option>
                    </select>
                    @error('duration_years')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Filière active</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="description" class="input-label">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="input">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn btn-primary">
                    Créer la filière
                </button>
                <a href="{{ route('admin.filieres.index') }}" class="btn btn-ghost">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
