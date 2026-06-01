@extends('layouts.dashboard')

@section('title', 'Mes Notes')

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
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Mes Résultats</h2>
            <p class="text-sm text-slate-400 mt-1 font-medium">Consultez vos notes par module.</p>
        </div>
        <a href="{{ route('etudiant.bulletin.pdf') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Télécharger PDF
        </a>
    </div>

    @if($grades->isEmpty())
        <div class="empty-state bg-white border border-slate-200 rounded-2xl">
            <div class="empty-state-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-base font-black text-slate-400">Aucune note disponible</h3>
            <p class="text-sm text-slate-300 mt-1">Vos résultats n'ont pas encore été publiés.</p>
        </div>
    @else
        <div class="space-y-5">
            @foreach($grades as $moduleName => $moduleGrades)
                @php $average = $moduleGrades->avg('score'); @endphp
                <div class="card overflow-hidden anim-slide-up">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="text-base font-black text-slate-900">{{ $moduleName }}</h3>
                            <p class="text-[11px] font-bold text-slate-400 mt-0.5">Année 2024-2025</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Moyenne</p>
                            <p class="text-lg font-black {{ $average >= 10 ? 'text-emerald-600' : 'text-rose-500' }}">{{ number_format($average, 2) }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Élément d'évaluation</th>
                                    <th class="text-center">Note / 20</th>
                                    <th class="text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moduleGrades as $grade)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                                </div>
                                                <span class="font-bold text-slate-700 text-sm">{{ $grade->moduleElement->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-base font-black {{ $grade->score >= 10 ? 'text-indigo-600' : 'text-rose-400' }}">{{ number_format($grade->score, 2) }}</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="badge {{ $grade->score >= 10 ? 'badge-success' : 'badge-danger' }}">{{ $grade->score >= 10 ? 'Validé' : 'Non Validé' }}</span>
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
