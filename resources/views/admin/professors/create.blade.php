@extends('layouts.admin-layout')

@section('title', 'Nouveau Professeur')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.professors.index') }}" class="btn btn-ghost mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Nouveau Professeur</h1>
        <p class="text-slate-500 mt-1">Ajouter un nouveau membre du corps professoral</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.professors.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="input-label">Prénom</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                        class="input">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="input-label">Nom</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                        class="input">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="input-label">Email professionnel</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="input">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="input-label">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="input">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="speciality" class="input-label">Spécialité</label>
                    <input type="text" id="speciality" name="speciality" value="{{ old('speciality') }}" required placeholder="ex: Informatique, Mathématiques..."
                        class="input">
                    @error('speciality')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hire_date" class="input-label">Date d'embauche</label>
                    <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date', date('Y-m-d')) }}" required
                        class="input">
                    @error('hire_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="input-label">Modules assignés (Optionnel)</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($modules as $module)
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-all">
                            <input type="checkbox" name="modules[]" value="{{ $module->id }}" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="text-sm text-slate-700">{{ $module->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn btn-primary">
                    Créer le professeur
                </button>
                <a href="{{ route('admin.professors.index') }}" class="btn btn-ghost">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
