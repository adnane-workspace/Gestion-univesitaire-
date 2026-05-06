@extends('layouts.auth')

@section('title', 'Connexion')
@section('subtitle', 'Ravi de vous revoir ! Accédez à votre espace.')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf
        
        <div>
            <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Adresse Email</label>
            <div class="relative group">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full pl-6 pr-4 py-4 rounded-2xl border-2 border-slate-50 bg-slate-50 text-slate-700 font-semibold focus:border-indigo-500 focus:bg-white transition-all outline-none"
                    placeholder="nom@exemple.com">
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none opacity-20 group-focus-within:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
            </div>
            @error('email')
                <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-3 ml-1">
                <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-[#4F46E5] uppercase tracking-widest hover:underline">
                        Oublié ?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <input type="password" id="password" name="password" required
                    class="w-full pl-6 pr-4 py-4 rounded-2xl border-2 border-slate-50 bg-slate-50 text-slate-700 font-semibold focus:border-indigo-500 focus:bg-white transition-all outline-none"
                    placeholder="••••••••">
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none opacity-20 group-focus-within:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002-2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>
            @error('password')
                <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center ml-1">
            <input type="checkbox" id="remember" name="remember" class="w-5 h-5 text-indigo-600 border-2 border-slate-200 rounded-lg focus:ring-indigo-500/20 transition-all cursor-pointer bg-slate-50">
            <label for="remember" class="ml-3 block text-sm font-bold text-slate-500 cursor-pointer">Se souvenir de moi</label>
        </div>

        <button type="submit" class="w-full bg-[#4F46E5] hover:bg-[#4338CA] text-white font-black py-5 px-4 rounded-2xl shadow-2xl shadow-indigo-200 transform transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
            <span>Se connecter</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>

        <div class="text-center pt-6 border-t border-slate-50">
            <p class="text-sm font-bold text-slate-400">
                Contactez l'administration pour obtenir vos identifiants.
            </p>
        </div>
    </form>
@endsection
