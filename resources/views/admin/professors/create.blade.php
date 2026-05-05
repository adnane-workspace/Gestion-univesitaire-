@extends('layouts.admin-layout')

@section('title', 'Nouveau Professeur')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.professors.index') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Nouveau Professeur</h1>
        <p class="text-slate-500 mt-1">Ajouter un nouveau membre du corps professoral</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.professors.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">Prénom</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Nom</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email professionnel</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="speciality" class="block text-sm font-medium text-slate-700 mb-2">Spécialité</label>
                    <input type="text" id="speciality" name="speciality" value="{{ old('speciality') }}" required placeholder="ex: Informatique, Mathématiques..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('speciality')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hire_date" class="block text-sm font-medium text-slate-700 mb-2">Date d'embauche</label>
                    <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('hire_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">Modules assignés (Optionnel)</label>
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
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow-md transition-all">
                    Créer le professeur
                </button>
                <a href="{{ route('admin.professors.index') }}" class="text-slate-600 hover:text-slate-800 px-6 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
