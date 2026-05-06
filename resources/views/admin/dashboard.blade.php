@extends('layouts.dashboard')

@section('title', 'Tableau de Bord Admin')

@section('sidebar-links')
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        Dashboard
    </a>
    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.students.*') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Étudiants
    </a>
    <a href="{{ route('admin.professors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.professors.*') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        Professeurs
    </a>
    <a href="{{ route('admin.filieres.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.filieres.*') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        Filières
    </a>
    <a href="{{ route('admin.modules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.modules.*') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Modules
    </a>
@endsection

@section('content')
    <!-- Overview Header -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-[#1E293B] tracking-tight">Vue d'ensemble</h2>
            <p class="text-slate-500 mt-2 font-medium">Contrôle global de l'établissement et des flux académiques.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm hover:bg-slate-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Exporter Rapport
            </button>
            <button class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 text-white text-sm font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Inscription
            </button>
        </div>
    </div>

    <!-- Real-time Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="flex items-center gap-1 text-xs font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
            </div>
            <p class="text-4xl font-black text-slate-800">{{ $stats['students_count'] ?? 0 }}</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Étudiants Inscrits</p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-50/50 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="flex items-center gap-1 text-xs font-black text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">Stable</span>
            </div>
            <p class="text-4xl font-black text-slate-800">{{ $stats['professors_count'] ?? 0 }}</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Corps Enseignant</p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-amber-50/50 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <span class="flex items-center gap-1 text-xs font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">Actif</span>
            </div>
            <p class="text-4xl font-black text-slate-800">{{ $stats['filieres_count'] ?? 0 }}</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Filières Ouvertes</p>
        </div>

        <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-white">100%</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Disponibilité Système</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Tables Section -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Recent Students -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                    <h3 class="text-xl font-bold text-[#1E293B]">Inscriptions Récentes</h3>
                    <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-600 text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">Voir Tout</a>
                </div>
                
                <div class="overflow-x-auto">
                    @if(isset($recent_students) && count($recent_students) > 0)
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Étudiant</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Filière</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($recent_students as $student)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-slate-600 group-hover:bg-[#4F46E5] group-hover:text-white transition-all">
                                                    {{ substr($student->first_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-[#1E293B]">{{ $student->first_name }} {{ $student->last_name }}</p>
                                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $student->student_id_number }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest border border-slate-200">
                                                {{ $student->filiere->code ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right font-medium text-slate-400 text-sm">
                                            {{ $student->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-20 flex flex-col items-center justify-center text-center opacity-40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h4 class="text-lg font-bold mt-4">Aucun étudiant</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side Widgets -->
        <div class="space-y-12">
            <!-- Weekly Progress Widget -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm p-8 flex flex-col">
                <h3 class="text-xl font-bold text-[#1E293B] mb-8">Activité Hebdomadaire</h3>
                
                <div class="flex-1 flex items-end justify-between gap-3 min-h-[220px] mb-8">
                    @php $days = ['L', 'M', 'M', 'J', 'V', 'S', 'D']; @endphp
                    @foreach($days as $day)
                        <div class="flex flex-col items-center gap-3 w-full">
                            @php $height = rand(30, 100); @endphp
                            <div class="w-full bg-slate-50 rounded-xl relative group overflow-hidden h-40">
                                <div class="absolute bottom-0 left-0 right-0 bg-indigo-600 rounded-xl transition-all duration-500 group-hover:brightness-110" style="height: {{ $height }}%"></div>
                            </div>
                            <span class="text-[10px] font-black text-slate-400">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-black text-slate-800">42</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sessions</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-black text-indigo-600">+14%</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">vs hier</p>
                    </div>
                </div>
            </div>

            <!-- Important Alerts -->
            <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-indigo-200">
                <h4 class="font-black text-lg mb-6">Alertes Système</h4>
                <div class="space-y-6">
                    <div class="flex gap-4 items-start">
                        <div class="w-2 h-2 rounded-full bg-amber-400 mt-2"></div>
                        <p class="text-sm font-medium text-indigo-100">5 notes en attente de validation pour le module SQL.</p>
                    </div>
                    <div class="flex gap-4 items-start">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 mt-2"></div>
                        <p class="text-sm font-medium text-indigo-100">Sauvegarde automatique effectuée avec succès.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
