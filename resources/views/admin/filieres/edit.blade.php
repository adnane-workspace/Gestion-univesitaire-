@extends('layouts.admin-layout')

@section('title', 'Modifier la Filière')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.filieres.index') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Modifier la Filière : {{ $filiere->name }}</h1>
        <p class="text-slate-500 mt-1">Mettre à jour les informations de la filière de formation</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.filieres.update', $filiere) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nom de la filière</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $filiere->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-slate-700 mb-2">Code (ex: SMI, SMA, SEG)</label>
                    <input type="text" id="code" name="code" value="{{ old('code', $filiere->code) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="duration_years" class="block text-sm font-medium text-slate-700 mb-2">Durée (années)</label>
                    <select id="duration_years" name="duration_years" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                        <option value="1" {{ old('duration_years', $filiere->duration_years) == 1 ? 'selected' : '' }}>1 an</option>
                        <option value="2" {{ old('duration_years', $filiere->duration_years) == 2 ? 'selected' : '' }}>2 ans</option>
                        <option value="3" {{ old('duration_years', $filiere->duration_years) == 3 ? 'selected' : '' }}>3 ans (Licence)</option>
                        <option value="5" {{ old('duration_years', $filiere->duration_years) == 5 ? 'selected' : '' }}>5 ans (Master/Ingénieur)</option>
                    </select>
                    @error('duration_years')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $filiere->is_active) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Filière active</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">{{ old('description', $filiere->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow-md transition-all">
                    Mettre à jour la filière
                </button>
                <a href="{{ route('admin.filieres.index') }}" class="text-slate-600 hover:text-slate-800 px-6 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
