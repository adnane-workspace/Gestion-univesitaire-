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
    <!-- Welcome Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-black text-[#1E293B]">Content de vous revoir, Admin ! 👋</h2>
        <p class="text-slate-500 mt-2 font-medium">Voici ce qui se passe aujourd'hui dans votre établissement.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <x-stat-card 
            title="Étudiants Total" 
            value="{{ $stats['students_count'] ?? 0 }}" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>' 
            color="indigo" 
            trend="{{ $stats['students_growth'] ?? 0 }}"
        />
        <x-stat-card 
            title="Corps Enseignant" 
            value="{{ $stats['professors_count'] ?? 0 }}" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>' 
            color="emerald" 
        />
        <x-stat-card 
            title="Filières Actives" 
            value="{{ $stats['filieres_count'] ?? 0 }}" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>' 
            color="amber" 
        />
        <x-stat-card 
            title="Salles Libres" 
            value="{{ $stats['rooms_available'] ?? 0 }}" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' 
            color="rose" 
        />
    </div>

    <!-- Data Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Recent Students -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-[#1E293B]">Dernières Inscriptions</h3>
                <a href="{{ route('admin.students.index') }}" class="text-sm font-bold text-[#4F46E5] hover:underline">Voir tout</a>
            </div>
            
            <div class="overflow-x-auto">
                @if(isset($recent_students) && count($recent_students) > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Étudiant</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Filière</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recent_students as $student)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-slate-600 group-hover:bg-[#4F46E5] group-hover:text-white transition-all">
                                                {{ substr($student->first_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-[#1E293B]">{{ $student->first_name }} {{ $student->last_name }}</p>
                                                <p class="text-xs text-slate-400 font-medium">{{ $student->student_id_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-[#4F46E5] text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                                            {{ $student->filiere->code ?? 'GINF' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <button class="p-2 hover:bg-slate-100 rounded-lg transition-colors text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-20 flex flex-col items-center justify-center text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-400">Aucune inscription récente</h4>
                        <p class="text-sm text-slate-300 mt-2 max-w-[250px]">Les nouveaux étudiants inscrits apparaîtront ici automatiquement.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Weekly Activity / Chart Placeholder -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm p-8 flex flex-col">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-xl font-bold text-[#1E293B]">Activités de la semaine</h3>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#4F46E5]"></span>
                    <span class="text-xs font-bold text-slate-400">Cours dispensés</span>
                </div>
            </div>
            
            <div class="flex-1 flex items-end justify-between gap-4 min-h-[300px]">
                @php $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']; @endphp
                @foreach($days as $day)
                    <div class="flex flex-col items-center gap-4 w-full">
                        @php $height = rand(30, 100); @endphp
                        <div class="w-full bg-slate-50 rounded-xl relative group overflow-hidden" style="height: 200px">
                            <div class="absolute bottom-0 left-0 right-0 bg-[#4F46E5] rounded-xl transition-all duration-500 group-hover:brightness-110" style="height: {{ $height }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $day }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
