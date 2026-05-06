@extends('layouts.dashboard')

@section('title', 'Mes Notes')

@section('sidebar-links')
    <a href="{{ route('etudiant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Tableau de bord
    </a>
    <a href="{{ route('etudiant.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Mes Notes
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Mes Résultats Académiques</h2>
        <p class="text-slate-500 mt-2">Consultez vos notes par module pour l'année universitaire en cours.</p>
    </div>

    @if($grades->isEmpty())
        <div class="text-center py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100">
            <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-400">Aucune note disponible</h3>
            <p class="text-slate-300 mt-2">Vos résultats n'ont pas encore été publiés par vos professeurs.</p>
        </div>
    @else
        <div class="space-y-8">
            @foreach($grades as $moduleName => $moduleGrades)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                    <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">{{ $moduleName }}</h3>
                            <p class="text-sm text-slate-500 mt-1">Année Universitaire : 2024-2025</p>
                        </div>
                        <div class="flex items-center gap-4">
                            @php
                                $average = $moduleGrades->avg('score');
                            @endphp
                            <div class="text-right">
                                <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Moyenne Module</p>
                                <p class="text-2xl font-black {{ $average >= 10 ? 'text-emerald-500' : 'text-rose-500' }}">
                                    {{ number_format($average, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left">
                                    <th class="px-10 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Élément d'évaluation</th>
                                    <th class="px-10 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em] text-center">Note / 20.00</th>
                                    <th class="px-10 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Observations</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($moduleGrades as $grade)
                                    <tr class="hover:bg-slate-50/50 transition-all group">
                                        <td class="px-10 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-slate-700">{{ $grade->moduleElement->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6 text-center">
                                            <span class="text-xl font-black {{ $grade->score >= 10 ? 'text-indigo-600' : 'text-rose-400' }}">
                                                {{ number_format($grade->score, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <span class="text-sm font-medium {{ $grade->score >= 10 ? 'text-emerald-600' : 'text-rose-500' }}">
                                                {{ $grade->score >= 10 ? 'Validé' : 'Non Validé' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
