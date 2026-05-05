@extends('layouts.dashboard')

@section('title', 'Tableau de Bord Administrateur')

@section('sidebar-links')
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Étudiants
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        Filières
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Modules
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-500 mb-1">Étudiants Inscrits</p>
            <p class="text-3xl font-bold text-slate-900">1,284</p>
            <p class="text-xs text-emerald-600 mt-2 font-semibold">↑ 12% ce mois</p>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-500 mb-1">Professeurs</p>
            <p class="text-3xl font-bold text-slate-900">84</p>
            <p class="text-xs text-slate-500 mt-2 font-semibold">Toutes filières</p>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-500 mb-1">Filières</p>
            <p class="text-3xl font-bold text-slate-900">12</p>
            <p class="text-xs text-slate-500 mt-2 font-semibold">Actives</p>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-500 mb-1">Salles Libres</p>
            <p class="text-3xl font-bold text-slate-900">5</p>
            <p class="text-xs text-amber-600 mt-2 font-semibold">Heure actuelle</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Dernières Inscriptions</h3>
            <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Voir tout</button>
        </div>
        <div class="p-8">
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-slate-500">Aucune donnée récente à afficher pour le moment.</p>
            </div>
        </div>
    </div>
@endsection
