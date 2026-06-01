@extends('layouts.auth')

@section('title', 'Connexion')
@section('subtitle', 'Accédez à votre espace académique')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="input-label">Adresse email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="input" placeholder="nom@exemple.com">
            @error('email')
                <p class="mt-1.5 text-xs font-bold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="input-label mb-0">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                        Oublié ?
                    </a>
                @endif
            </div>
            <input type="password" id="password" name="password" required
                class="input" placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs font-bold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" id="remember" name="remember"
                class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500/20 transition-all cursor-pointer">
            <label for="remember" class="text-sm font-semibold text-slate-500 cursor-pointer select-none">Se souvenir de moi</label>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200/50 hover:shadow-xl hover:shadow-indigo-300/50 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm">
            <span>Se connecter</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>

        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-xs font-semibold text-slate-400">
                Contactez l'administration pour obtenir vos identifiants.
            </p>
        </div>
    </form>
@endsection
