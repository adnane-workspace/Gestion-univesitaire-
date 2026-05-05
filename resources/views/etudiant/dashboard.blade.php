@extends('layouts.dashboard')

@section('title', 'Mon Espace Étudiant')

@section('sidebar-links')
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Mon Profil
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
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
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Ma Progression</h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Moyenne Générale</p>
                            <p class="text-2xl font-bold text-indigo-600">14.50 / 20</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Crédits Validés</p>
                            <p class="text-2xl font-bold text-slate-800">45 / 60</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Rang</p>
                            <p class="text-2xl font-bold text-slate-800">5ème / 120</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Emploi du temps du jour</h3>
                    <span class="text-sm text-slate-500">{{ date('d M Y') }}</span>
                </div>
                <div class="p-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-6 p-4 rounded-2xl bg-indigo-50 border border-indigo-100">
                            <div class="text-center min-w-[60px]">
                                <p class="text-sm font-bold text-indigo-700">08:30</p>
                                <p class="text-xs text-indigo-400">10:30</p>
                            </div>
                            <div class="w-px h-10 bg-indigo-200"></div>
                            <div>
                                <p class="font-bold text-slate-800">Algorithmique Avancée</p>
                                <p class="text-xs text-slate-500">Salle A12 - Prof. {{ Auth::user()->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                <h3 class="font-bold text-slate-800 mb-6">Informations Filière</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Filière</p>
                        <p class="font-semibold text-slate-800">Génie Informatique</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Année</p>
                        <p class="font-semibold text-slate-800">2ème Année (S3)</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Coordonnateur</p>
                        <p class="font-semibold text-slate-800">Dr. Ahmed Bennani</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
