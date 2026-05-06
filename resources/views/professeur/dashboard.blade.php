@extends('layouts.dashboard')

@section('title', 'Espace Professeur')

@section('sidebar-links')
    <a href="{{ route('professeur.modules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium {{ request()->routeIs('professeur.modules') ? 'bg-indigo-600 text-white' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Mes Modules
    </a>
    <a href="{{ route('professeur.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium {{ request()->routeIs('professeur.grades') ? 'bg-indigo-600 text-white' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Saisie des Notes
    </a>
    <a href="{{ route('professeur.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium {{ request()->routeIs('professeur.schedule') ? 'bg-indigo-600 text-white' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="bg-indigo-600 rounded-3xl p-8 text-white mb-8 shadow-xl shadow-indigo-200">
        <h2 class="text-2xl font-bold mb-2">Bonjour, Prof. {{ $professor->first_name }} {{ $professor->last_name }} !</h2>
        <p class="text-indigo-100">Vous avez {{ $schedulesCount }} cours prévus aujourd'hui.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
                Modules Assignés ({{ $modules->count() }})
            </h3>
            <div class="space-y-4">
                @foreach($modules as $module)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-800">{{ $module->name }}</p>
                            <p class="text-xs text-slate-500 uppercase tracking-widest mt-1">{{ $module->filiere->name }} - S{{ $module->semester }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">{{ $module->is_active ? 'ACTIF' : 'INACTIF' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                Statistiques Rapides
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-100">
                    <p class="text-3xl font-bold text-emerald-600">{{ $studentsCount }}</p>
                    <p class="text-sm text-slate-600 mt-1">Étudiants suivis</p>
                </div>
                <div class="p-6 rounded-2xl bg-blue-50 border border-blue-100">
                    <p class="text-3xl font-bold text-blue-600">{{ $modules->sum('credits') }}</p>
                    <p class="text-sm text-slate-600 mt-1">Crédits totaux</p>
                </div>
            </div>
        </div>
    </div>
@endsection

