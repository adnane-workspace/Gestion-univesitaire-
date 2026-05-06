@extends('layouts.dashboard')

@section('title', 'Mon Espace Étudiant')

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
                            @php
                                $totalAverage = $student->grades->avg('score') ?? 0;
                            @endphp
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($totalAverage, 2) }} / 20</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Modules En cours</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $student->filiere->modules->count() }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Année</p>
                            <p class="text-2xl font-bold text-slate-800">2024-2025</p>
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
                    @php
                        $today = \Carbon\Carbon::now()->locale('fr')->dayName;
                        $todaySchedule = \App\Models\Schedule::whereHas('module', function($q) use ($student) {
                            $q->where('filiere_id', $student->filiere_id);
                        })->where('day', ucfirst($today))->with(['module', 'room', 'professor'])->orderBy('start_time')->get();
                    @endphp

                    @if($todaySchedule->isEmpty())
                        <p class="text-slate-400 italic">Aucun cours prévu pour aujourd'hui.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($todaySchedule as $item)
                                <div class="flex items-center gap-6 p-4 rounded-2xl bg-indigo-50 border border-indigo-100">
                                    <div class="text-center min-w-[60px]">
                                        <p class="text-sm font-bold text-indigo-700">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</p>
                                        <p class="text-xs text-indigo-400">{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</p>
                                    </div>
                                    <div class="w-px h-10 bg-indigo-200"></div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $item->module->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->room->name }} - Prof. {{ $item->professor->last_name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                <h3 class="font-bold text-slate-800 mb-6">Informations Filière</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Filière</p>
                        <p class="font-semibold text-slate-800">{{ $student->filiere->name }} ({{ $student->filiere->code }})</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">ID Étudiant</p>
                        <p class="font-semibold text-slate-800">{{ $student->student_id_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Email Académique</p>
                        <p class="font-semibold text-slate-800">{{ $student->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
