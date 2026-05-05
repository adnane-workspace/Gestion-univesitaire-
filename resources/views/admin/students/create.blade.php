@extends('layouts.admin-layout')

@section('title', 'Nouvel Étudiant')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Nouvel Étudiant</h1>
        <p class="text-slate-500 mt-1">Ajouter un nouvel étudiant à l'université</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-6">
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
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
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
                    <label for="student_id_number" class="block text-sm font-medium text-slate-700 mb-2">Numéro de matricule</label>
                    <input type="text" id="student_id_number" name="student_id_number" value="{{ old('student_id_number') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('student_id_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-slate-700 mb-2">Date de naissance</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-slate-700 mb-2">Adresse</label>
                <textarea id="address" name="address" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow-md transition-all">
                    Créer l'étudiant
                </button>
                <a href="{{ route('admin.students.index') }}" class="text-slate-600 hover:text-slate-800 px-6 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
