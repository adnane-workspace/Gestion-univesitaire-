@extends('layouts.dashboard')

@section('title', 'Mon Espace Étudiant')

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

@php
    $today = \Carbon\Carbon::now()->locale('fr')->dayName;
    $todayName = ucfirst($today);
    $now = \Carbon\Carbon::now();
    $gpa = $student->calculateGPA();
    $avg = $student->grades->avg('score') ?? 0;
    $absences = \App\Models\Absence::where('student_id', $student->id)->count();
    $totalModules = $student->filiere->modules()->count();
    $todaySchedule = \App\Models\Schedule::whereHas('module', function($q) use ($student) {
        $q->where('filiere_id', $student->filiere_id);
    })->where('day', $todayName)->with(['module', 'room', 'professor'])->orderBy('start_time')->get();
    $recentGrades = $student->grades()->with(['moduleElement.module'])->latest()->take(4)->get();
@endphp

{{-- ═══════════════════════════════════════════════ WELCOME BANNER --}}
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-700 rounded-2xl p-6 lg:p-8 mb-6 shadow-xl shadow-indigo-200/40 anim-slide-up">
    <div class="absolute top-0 right-0 w-80 h-80 bg-white/[0.06] rounded-full -translate-y-1/3 translate-x-1/4 blur-2xl"></div>
    <div class="absolute bottom-0 left-0 w-60 h-60 bg-violet-400/10 rounded-full translate-y-1/2 -translate-x-1/4 blur-2xl"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
        <div>
            <h2 class="text-2xl lg:text-3xl font-black text-white tracking-tight">
                Bonjour, <span class="text-yellow-300">{{ $student->first_name }}</span>
            </h2>
            <p class="text-indigo-200 text-sm font-medium mt-1">
                {{ ucfirst($today) }} {{ $now->format('d/m/Y') }} — Voici un résumé de votre espace.
            </p>
            <div class="flex flex-wrap gap-2 mt-4">
                <a href="{{ route('etudiant.schedule') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white/15 hover:bg-white/25 backdrop-blur-md text-white text-xs font-bold rounded-xl border border-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Planning
                </a>
                <a href="{{ route('etudiant.bulletin.pdf') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-indigo-700 text-xs font-bold rounded-xl shadow-lg shadow-indigo-900/20 hover:bg-slate-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Bulletin
                </a>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="bg-white/10 backdrop-blur-md rounded-xl px-5 py-3 border border-white/10 text-center min-w-[100px]">
                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-300">Moyenne</p>
                <p class="text-xl font-black text-white">{{ number_format($avg, 1) }}<span class="text-xs opacity-60">/20</span></p>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-xl px-5 py-3 border border-white/10 text-center min-w-[100px]">
                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-300">Absences</p>
                <p class="text-xl font-black text-white">{{ $absences }}<span class="text-xs opacity-60">h</span></p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════ STAT CARDS --}}
@php
    $stats = [
        ['label' => 'GPA', 'value' => number_format($gpa, 2), 'suffix' => '/ 4', 'color' => 'text-indigo-600', 'bg' => 'bg-indigo-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
        ['label' => 'Modules', 'value' => $totalModules, 'suffix' => 'cours', 'color' => 'text-violet-600', 'bg' => 'bg-violet-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
        ['label' => "Aujourd'hui", 'value' => $todaySchedule->count(), 'suffix' => 'cours', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
        ['label' => 'Notes', 'value' => $student->grades()->count(), 'suffix' => 'notes', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
    ];
@endphp
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    @foreach($stats as $i => $stat)
    <div class="card p-4 anim-slide-up anim-delay-{{ $i + 1 }}">
        <div class="flex items-center justify-between mb-2">
            <div class="w-9 h-9 rounded-xl {{ $stat['bg'] }} flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $stat['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $stat['icon'] !!}</svg>
            </div>
        </div>
        <p class="text-xl font-black text-slate-900">{{ $stat['value'] }} <span class="text-xs font-bold text-slate-400">{{ $stat['suffix'] }}</span></p>
        <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $stat['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">

        {{-- ═══════════════════════════════════════════════ SCHEDULE WIDGET --}}
        <div class="card overflow-hidden anim-slide-up anim-delay-2">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Planning du jour</h3>
                        <p class="text-[11px] font-bold text-slate-400">{{ $todaySchedule->count() }} cours</p>
                    </div>
                </div>
                <a href="{{ route('etudiant.schedule') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="p-4">
                @if($todaySchedule->isEmpty())
                    <div class="py-10 text-center">
                        <div class="w-14 h-14 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400">Pas de cours aujourd'hui</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($todaySchedule as $item)
                        @php
                            $start = \Carbon\Carbon::parse($item->start_time);
                            $end = \Carbon\Carbon::parse($item->end_time);
                            $isPast = $now->gt($end);
                            $isCurrent = $now->between($start, $end);
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl {{ $isCurrent ? 'bg-indigo-50 border border-indigo-200' : ($isPast ? 'bg-slate-50/50 border border-slate-100 opacity-60' : 'bg-white border border-slate-100 hover:border-slate-200') }} transition-all">
                            <div class="text-center min-w-[50px] shrink-0">
                                <p class="text-sm font-black {{ $isCurrent ? 'text-indigo-600' : 'text-slate-700' }}">{{ $start->format('H:i') }}</p>
                                <p class="text-[10px] text-slate-400 font-bold">{{ $end->format('H:i') }}</p>
                            </div>
                            <div class="w-px h-8 {{ $isCurrent ? 'bg-indigo-200' : 'bg-slate-200' }} shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black {{ $isCurrent ? 'text-indigo-700' : 'text-slate-800' }} truncate">{{ $item->module->name }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[11px] font-bold text-slate-400">{{ $item->room->name }}</span>
                                    <span class="text-slate-300">·</span>
                                    <span class="text-[11px] font-bold text-slate-400">Pr. {{ $item->professor->last_name }}</span>
                                </div>
                            </div>
                            @if($isCurrent)
                                <span class="flex items-center gap-1 px-2 py-0.5 bg-indigo-600 text-white text-[10px] font-bold rounded-full shrink-0">
                                    <span class="w-1 h-1 rounded-full bg-white animate-pulse"></span>En cours
                                </span>
                            @elseif($isPast)
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-400 text-[10px] font-bold rounded-full shrink-0">Terminé</span>
                            @else
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-full border border-emerald-100 shrink-0">À venir</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════ RECENT GRADES --}}
        <div class="card overflow-hidden anim-slide-up anim-delay-3">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Résultats récents</h3>
                        <p class="text-[11px] font-bold text-slate-400">{{ $recentGrades->count() }} dernières notes</p>
                    </div>
                </div>
                <a href="{{ route('etudiant.grades') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                    Relevé complet
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="p-4">
                @if($recentGrades->isEmpty())
                    <p class="text-center text-sm text-slate-400 py-8 font-semibold">Aucune note saisie.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($recentGrades as $grade)
                        @php $passed = $grade->score >= 10; @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-slate-200 transition-all">
                            <div class="w-10 h-10 rounded-lg {{ $passed ? 'bg-emerald-50 border border-emerald-100' : 'bg-rose-50 border border-rose-100' }} flex items-center justify-center shrink-0">
                                <span class="text-xs font-black {{ $passed ? 'text-emerald-600' : 'text-rose-600' }}">{{ number_format($grade->score, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-wider text-slate-400 truncate">{{ $grade->moduleElement->module->name }}</p>
                                <p class="text-xs font-bold text-slate-700 truncate">{{ $grade->moduleElement->name }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════ RIGHT SIDEBAR --}}
    <div class="space-y-5">
        {{-- Profile Card --}}
        <div class="card overflow-hidden anim-slide-up anim-delay-3">
            <div class="h-16 bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 relative">
                <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;20&quot; height=&quot;20&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Ccircle cx=&quot;1&quot; cy=&quot;1&quot; r=&quot;0.8&quot; fill=&quot;white&quot;/%3E%3C/svg%3E');"></div>
            </div>
            <div class="px-5 pb-5 text-center -mt-8 relative">
                <div class="w-16 h-16 rounded-xl bg-white p-0.5 mx-auto mb-2 shadow-lg shadow-slate-200/50">
                    <div class="w-full h-full rounded-[10px] bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-lg font-black text-white">
                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                    </div>
                </div>
                <h4 class="text-base font-black text-slate-900">{{ $student->first_name }} {{ $student->last_name }}</h4>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.15em] mt-0.5">{{ $student->filiere->code }}</p>

                <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-left">
                    @foreach([
                        ['Matricule', $student->student_id_number],
                        ['Niveau', 'Semestre 6'],
                        ['Email', Str::limit($student->email, 20)],
                        ['Filière', Str::limit($student->filiere->name, 20)],
                    ] as [$label, $value])
                    <div class="flex items-center justify-between py-0.5">
                        <span class="text-[11px] font-bold text-slate-400">{{ $label }}</span>
                        <span class="text-[11px] font-bold text-slate-700">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Progress --}}
        <div class="bg-slate-900 rounded-2xl p-5 text-white shadow-xl anim-slide-up anim-delay-4">
            <h4 class="font-black text-sm mb-4">Récapitulatif</h4>
            <div class="space-y-4">
                @foreach([
                    ['Moyenne', number_format($avg, 1).'/20', ($avg/20)*100, 'from-indigo-500 to-indigo-400'],
                    ['GPA', number_format($gpa, 2).'/4', ($gpa/4)*100, 'from-violet-500 to-violet-400'],
                    ['Assiduité', $absences.' absence'.($absences > 1 ? 's' : ''), max(100 - ($absences * 10), 0), $absences > 3 ? 'from-rose-500 to-rose-400' : 'from-emerald-500 to-emerald-400'],
                ] as [$label, $val, $pct, $grad])
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $label }}</span>
                        <span class="text-[11px] font-black">{{ $val }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r {{ $grad }} rounded-full transition-all duration-1000" style="width: {{ min($pct, 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('etudiant.bulletin.pdf') }}" class="w-full mt-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 transition-all font-bold text-xs flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Télécharger bulletin
            </a>
        </div>

        {{-- Guide --}}
        <div class="card p-5 anim-slide-up anim-delay-5">
            <h4 class="text-sm font-black text-slate-900 mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Infos pratiques
            </h4>
            <div class="space-y-2">
                <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg">
                    <span class="text-xs mt-0.5 shrink-0">📌</span>
                    <p class="text-[11px] font-bold text-slate-600 leading-relaxed">Bureau ouvert de 08:30 à 17:00</p>
                </div>
                <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg">
                    <span class="text-xs mt-0.5 shrink-0">📧</span>
                    <p class="text-[11px] font-bold text-slate-600 leading-relaxed">contact.scolarite@upf.ma</p>
                </div>
                <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg">
                    <span class="text-xs mt-0.5 shrink-0">💬</span>
                    <p class="text-[11px] font-bold text-slate-600 leading-relaxed">Assistant virtuel 24h/24</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
