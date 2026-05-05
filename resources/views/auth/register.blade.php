@extends('layouts.auth')

@section('title', 'Inscription')
@section('subtitle', 'Créez votre compte pour accéder à la plateforme')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nom complet</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                placeholder="Jean Dupont">
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Adresse Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                placeholder="jean@exemple.com">
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">Je suis un...</label>
            <select id="role" name="role" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white appearance-none">
                <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                <option value="professeur" {{ old('role') == 'professeur' ? 'selected' : '' }}>Professeur</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                    placeholder="••••••••">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Confirmer</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                    placeholder="••••••••">
            </div>
        </div>
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200 transform transition-all active:scale-[0.98] mt-2">
            Créer mon compte
        </button>

        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-sm text-slate-600">
                Déjà inscrit ? 
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    Se connecter
                </a>
            </p>
        </div>
    </form>
@endsection
