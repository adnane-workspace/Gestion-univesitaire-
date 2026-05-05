@extends('layouts.auth')

@section('title', 'Connexion')
@section('subtitle', 'Connectez-vous à votre espace personnel')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                placeholder="nom@exemple.com">
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-slate-700">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                        Oublié ?
                    </a>
                @endif
            </div>
            <input type="password" id="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                placeholder="••••••••">
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition-all">
            <label for="remember" class="ml-2 block text-sm text-slate-600">Se souvenir de moi</label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200 transform transition-all active:scale-[0.98]">
            Se connecter
        </button>

        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-sm text-slate-600">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    S'inscrire
                </a>
            </p>
        </div>
    </form>
@endsection
