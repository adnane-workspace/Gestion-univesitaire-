@extends('layouts.dashboard')

@section('title', 'Mes Modules')

@section('sidebar-links')
    <a href="{{ route('professeur.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.dashboard') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Tableau de bord
    </a>
    <a href="{{ route('professeur.modules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.modules') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Mes Modules
    </a>
    <a href="{{ route('professeur.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.grades') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Saisie des Notes
    </a>
    <a href="{{ route('professeur.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.schedule') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($modules as $module)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-8 border-b border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">{{ $module->code }}</span>
                        <span class="text-slate-400 text-xs font-medium uppercase tracking-widest">{{ $module->filiere->name }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $module->name }}</h3>
                    <p class="text-slate-500 mt-2 text-sm">{{ Str::limit($module->description, 100) }}</p>
                </div>
                <div class="bg-slate-50 p-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Éléments de module</h4>
                    <div class="space-y-3">
                        @foreach($module->moduleElements as $element)
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-slate-700">{{ $element->name }}</span>
                                <span class="text-xs font-bold text-slate-500">{{ $element->coefficient * 100 }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="p-6 bg-white border-t border-slate-100 flex gap-4">
                    <a href="{{ route('professeur.grades', ['module_id' => $module->id]) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-indigo-100">
                        Saisir les notes
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
