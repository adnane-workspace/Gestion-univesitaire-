@extends('layouts.dashboard')

@section('title', 'Mon Emploi du Temps')

@section('sidebar-links')
    <a href="{{ route('etudiant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.dashboard') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Tableau de bord
    </a>
    <a href="{{ route('etudiant.modules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.modules') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Mes Modules
    </a>
    <a href="{{ route('etudiant.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.grades') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Mes Notes
    </a>
    <a href="{{ route('etudiant.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.schedule') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Emploi du temps</h2>
        <p class="text-slate-500 mt-2">Votre planning de cours pour la semaine en cours.</p>
    </div>

    @if($schedules->isEmpty())
        <div class="text-center py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-400">Aucun cours planifié</h3>
            <p class="text-slate-300 mt-2">Votre emploi du temps n'a pas encore été généré par l'administration.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-8">
            @php
                $groupedSchedules = $schedules->groupBy('day');
                $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            @endphp

            @foreach($days as $day)
                @if(isset($groupedSchedules[$day]))
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="px-6 py-2 rounded-2xl bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-100">
                                {{ $day }}
                            </div>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($groupedSchedules[$day] as $item)
                                <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all flex items-center gap-6 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    
                                    <div class="text-center min-w-[70px] py-2 border-r border-slate-100 pr-6">
                                        <p class="text-lg font-black text-indigo-600">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</p>
                                        <p class="text-xs font-bold text-slate-400 mt-1 uppercase">{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</p>
                                    </div>

                                    <div class="flex-1">
                                        <h4 class="font-bold text-slate-800 text-lg leading-tight mb-1">{{ $item->module->name }}</h4>
                                        <div class="flex flex-wrap gap-x-4 gap-y-1">
                                            <p class="text-xs font-semibold text-slate-400 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $item->room->name }}
                                            </p>
                                            <p class="text-xs font-semibold text-indigo-400 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Prof. {{ $item->professor->last_name }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-500"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
@endsection
