@extends('layouts.dashboard')

@section('title', 'Mes Modules')

@section('sidebar-links')
    <a href="{{ route('etudiant.dashboard') }}" class="sidebar-link {{ request()->routeIs('etudiant.dashboard') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Tableau de bord
    </a>
    <a href="{{ route('etudiant.modules') }}" class="sidebar-link {{ request()->routeIs('etudiant.modules') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        Mes Modules
    </a>
    <a href="{{ route('etudiant.grades') }}" class="sidebar-link {{ request()->routeIs('etudiant.grades') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        Mes Notes
    </a>
    <a href="{{ route('etudiant.schedule') }}" class="sidebar-link {{ request()->routeIs('etudiant.schedule') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Mes Modules</h2>
        <p class="text-sm text-slate-400 mt-1 font-medium">Liste des modules de votre filière.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($modules as $module)
            <div class="card card-hover p-5 anim-slide-up" style="animation-delay: {{ $loop->index * 0.05 }}s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="badge badge-neutral">{{ $module->code }}</span>
                </div>
                <h3 class="text-base font-black text-slate-900 mb-1">{{ $module->name }}</h3>
                <p class="text-xs text-slate-400 font-medium mb-4 line-clamp-2">Concepts fondamentaux et avancés de ce module.</p>

                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Prof. {{ $module->professors->first()->first_name ?? 'N/A' }} {{ $module->professors->first()->last_name ?? '' }}
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $module->hours }}h de cours
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('etudiant.modules.qcm', ['module' => $module->id]) }}" class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-xs font-bold text-white hover:bg-indigo-700 transition">Réviser le QCM</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
