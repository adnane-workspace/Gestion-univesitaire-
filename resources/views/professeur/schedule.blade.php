@extends('layouts.dashboard')

@section('title', 'Emploi du temps')

@section('sidebar-links')
    <a href="{{ route('professeur.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Tableau de bord
    </a>
    <a href="{{ route('professeur.modules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Mes Modules
    </a>
    <a href="{{ route('professeur.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Saisie des Notes
    </a>
    <a href="{{ route('professeur.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Calendrier des cours</h3>
            <div class="flex gap-2">
                <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-widest">Aujourd'hui : {{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Date & Heure</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Module</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Salle</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Type</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedules as $session)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800">{{ $session->date->format('l d F') }}</span>
                                    <span class="text-xs text-indigo-600 font-bold uppercase tracking-widest">{{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 font-bold text-slate-700">{{ $session->module->name }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 font-bold text-xs">{{ $session->room->name }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-widest">{{ $session->type }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic">Aucun cours programmé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
