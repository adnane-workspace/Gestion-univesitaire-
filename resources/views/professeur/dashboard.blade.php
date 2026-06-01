@extends('layouts.dashboard')

@section('title', 'Espace Professeur')

@section('sidebar-links')
    <a href="{{ route('professeur.dashboard') }}" class="sidebar-link {{ request()->routeIs('professeur.dashboard') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Tableau de bord
    </a>
    <a href="{{ route('professeur.modules') }}" class="sidebar-link {{ request()->routeIs('professeur.modules') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        Mes Modules
    </a>
    <a href="{{ route('professeur.grades') }}" class="sidebar-link {{ request()->routeIs('professeur.grades') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        Saisie des Notes
    </a>
    <a href="{{ route('professeur.absences') }}" class="sidebar-link {{ request()->routeIs('professeur.absences') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Absences
    </a>
    <a href="{{ route('professeur.schedule') }}" class="sidebar-link {{ request()->routeIs('professeur.schedule') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <!-- Welcome Header -->
    <div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-10 mb-10 shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h2 class="text-4xl font-black text-white mb-2">Bonjour, Prof. {{ $professor->last_name }} ! 👋</h2>
                <p class="text-slate-400 text-lg font-medium">Prêt pour vos {{ $schedulesCount }} sessions d'aujourd'hui ?</p>
                
                <div class="flex gap-4 mt-8">
                    <a href="{{ route('professeur.grades') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl px-8 py-3 font-bold text-sm transition-all shadow-xl shadow-indigo-900/20">
                        Saisir des notes
                    </a>
                    <a href="{{ route('professeur.absences') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl px-8 py-3 font-bold text-sm transition-all shadow-xl shadow-emerald-900/20">
                        Suivi des absences
                    </a>
                    <a href="{{ route('professeur.schedule') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/10 rounded-2xl px-8 py-3 font-bold text-sm transition-all">
                        Mon planning
                    </a>
                </div>
            </div>
            
            <div class="flex gap-6">
                <div class="bg-white/5 backdrop-blur-md rounded-[2rem] p-6 border border-white/10 text-center min-w-[140px]">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Étudiants</p>
                    <p class="text-4xl font-black text-white">{{ $studentsCount }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-[2rem] p-6 border border-white/10 text-center min-w-[140px]">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Modules</p>
                    <p class="text-4xl font-black text-white">{{ $modules->count() }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-[2rem] p-6 border border-white/10 text-center min-w-[140px]">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Absences aujourd'hui</p>
                    <p class="text-4xl font-black text-white">{{ $absencesCount }}</p>
                </div>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Today's Classes -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">Prochaines sessions</h3>
                    <span class="px-4 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest">{{ now()->locale('fr')->isoFormat('dddd D MMMM') }}</span>
                </div>
                <div class="p-8">
                    @php
                        $todaySchedule = $todaySchedules;
                    @endphp

                    @if($todaySchedule->isEmpty())
                        <div class="py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-400">Aucun cours aujourd'hui</h4>
                            <p class="text-sm text-slate-300 mt-2">Profitez de ce temps pour préparer vos prochains supports.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($todaySchedule as $item)
                                <div class="relative group p-6 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:border-indigo-100 transition-all hover:shadow-xl hover:shadow-indigo-50">
                                    <div class="flex items-center gap-6">
                                        <div class="bg-white p-4 rounded-2xl shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                            <p class="text-lg font-black">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</p>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-black text-slate-800 text-lg">{{ $item->module?->name ?? 'Module non renseigne' }}</h4>
                                            <div class="flex items-center gap-4 mt-1">
                                                <span class="flex items-center gap-1 text-xs font-bold text-slate-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    </svg>
                                                    {{ $item->room?->name ?? 'Salle non renseignee' }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest">{{ $item->type }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('professeur.grades', ['module_id' => $item->module_id]) }}" class="hidden md:flex items-center gap-2 px-6 py-3 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                            Liste d'appel
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modules Grid -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm p-8">
                <h3 class="text-xl font-bold text-slate-800 mb-8 flex items-center justify-between">
                    Mes Modules d'Enseignement
                    <a href="{{ route('professeur.modules') }}" class="text-sm text-indigo-600 hover:underline">Voir détails</a>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($modules as $module)
                        <div class="p-6 rounded-[2rem] border border-slate-100 bg-slate-50/50 hover:border-indigo-100 transition-all group">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 rounded-full bg-white border border-slate-200 text-[10px] font-black text-slate-500">{{ $module->code }}</span>
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>
                            <h4 class="font-black text-slate-800 mb-1 leading-tight">{{ $module->name }}</h4>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $module->filiere->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-10">
            <!-- Stats Circular -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm p-10 text-center">
                <div class="relative w-40 h-40 mx-auto mb-8">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="text-indigo-600" stroke-dasharray="85, 100" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <p class="text-4xl font-black text-slate-800">85%</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Saisie Notes</p>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800">Progression semestrielle</h4>
                <p class="text-sm text-slate-400 mt-2">Vous avez presque terminé la saisie de toutes les notes pour vos modules.</p>
            </div>

            <!-- Academic Calendar -->
            <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-200">
                <h4 class="font-black text-lg mb-6">Dates Clés</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex flex-col items-center justify-center border border-white/10">
                            <span class="text-xs font-black">15</span>
                            <span class="text-[8px] uppercase font-bold text-indigo-200">Mai</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Rendu des notes</p>
                            <p class="text-xs text-indigo-200">Date limite semestre 2</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex flex-col items-center justify-center border border-white/10">
                            <span class="text-xs font-black">22</span>
                            <span class="text-[8px] uppercase font-bold text-indigo-200">Mai</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Conseil de classe</p>
                            <p class="text-xs text-indigo-200">Session normale GINF</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
