@extends('layouts.dashboard')

@section('title', 'Saisie des Notes')

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
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Gestion des Évaluations</h2>
        <p class="text-slate-500 mt-2">Sélectionnez un module pour saisir les notes de vos étudiants.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 p-8 mb-8 overflow-hidden relative">
        <div class="absolute top-0 right-0 p-8 opacity-10 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </div>
        
        <form action="{{ route('professeur.grades') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
            <div class="group">
                <label class="block text-sm font-bold text-slate-500 mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Module d'enseignement
                </label>
                <select name="module_id" onchange="this.form.submit()" class="w-full bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl px-6 py-4 transition-all outline-none text-slate-700 font-semibold shadow-sm">
                    <option value="">-- Choisir un module --</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ $selectedModuleId == $module->id ? 'selected' : '' }}>{{ $module->name }} ({{ $module->code }})</option>
                    @endforeach
                </select>
            </div>

            <div class="group">
                <label class="block text-sm font-bold text-slate-500 mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Élément d'évaluation
                </label>
                <select name="element_id" onchange="this.form.submit()" {{ !$selectedModuleId ? 'disabled' : '' }} class="w-full bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl px-6 py-4 transition-all outline-none text-slate-700 font-semibold shadow-sm {{ !$selectedModuleId ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <option value="">-- Choisir l'élément (Examen, TP, etc.) --</option>
                    @if($selectedModuleId)
                        @foreach($modules->firstWhere('id', $selectedModuleId)->moduleElements as $element)
                            <option value="{{ $element->id }}" {{ $selectedElementId == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </form>
    </div>

    @if($selectedElementId && count($students) > 0)
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
            <form action="{{ route('professeur.grades.store') }}" method="POST">
                @csrf
                <input type="hidden" name="element_id" value="{{ $selectedElementId }}">
                
                <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Liste des étudiants</h3>
                        <p class="text-sm text-slate-500 mt-1">Saisissez les notes sur 20. Laissez vide si l'étudiant était absent.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-full">{{ count($students) }} Étudiants</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left">
                                <th class="px-10 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Profil Étudiant</th>
                                <th class="px-10 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em] text-center">Note / 20.00</th>
                                <th class="px-10 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($students as $student)
                                @php
                                    $grade = $student->grades()->where('module_element_id', $selectedElementId)->first();
                                    $hasGrade = $grade && $grade->score !== null;
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-all group">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center gap-5">
                                            <div class="relative">
                                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-100 group-hover:scale-105 transition-transform">
                                                    {{ substr($student->first_name, 0, 1) }}
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                                    <div class="w-2.5 h-2.5 rounded-full {{ $hasGrade ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">{{ $student->first_name }} {{ $student->last_name }}</p>
                                                <p class="text-sm text-slate-400 font-medium tracking-tight mt-0.5">{{ $student->student_id_number }} • GINF 3</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <div class="relative max-w-[120px] mx-auto group/input">
                                            <input type="number" step="0.25" min="0" max="20" name="grades[{{ $student->id }}]" value="{{ $grade ? $grade->score : '' }}"
                                                class="w-full text-center bg-slate-50 border-2 border-transparent group-hover/input:bg-white group-hover/input:border-indigo-100 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl px-4 py-3 font-bold text-xl text-slate-800 transition-all outline-none">
                                        </div>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        @if($hasGrade)
                                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Saisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-slate-50 text-slate-500 text-xs font-bold border border-slate-100">
                                                En attente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-10 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4 text-slate-500 text-sm italic">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Toutes les modifications sont enregistrées après validation.
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white px-12 py-5 rounded-[1.5rem] font-bold text-lg transition-all shadow-2xl shadow-indigo-200 flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer les notes
                    </button>
                </div>
            </form>
        </div>
    @elseif($selectedElementId)
        <div class="text-center py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-400">Aucun étudiant trouvé</h3>
            <p class="text-slate-300 mt-2">Aucun étudiant n'est encore inscrit à ce module.</p>
        </div>
    @else
        <div class="text-center py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100">
            <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-400">Prêt pour la saisie ?</h3>
            <p class="text-slate-300 mt-2">Veuillez sélectionner un module et un élément d'évaluation ci-dessus.</p>
        </div>
    @endif
@endsection

