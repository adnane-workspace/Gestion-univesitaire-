@extends('layouts.dashboard')

@section('title', 'Mon Emploi du Temps')

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
    $days        = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $today       = ucfirst(\Carbon\Carbon::now()->locale('fr')->dayName);

    $timeSlots = $schedules->map(function($s) {
        return \Carbon\Carbon::parse($s->start_time)->format('H:i')
             . '|'
             . \Carbon\Carbon::parse($s->end_time)->format('H:i');
    })->unique()->sort()->values();

    $matrix = [];
    foreach ($schedules as $s) {
        $key = \Carbon\Carbon::parse($s->start_time)->format('H:i')
             . '|'
             . \Carbon\Carbon::parse($s->end_time)->format('H:i');
        $matrix[$key][$s->day] = $s;
    }
    ksort($matrix);

    $palette = [
        ['dot'=>'bg-indigo-500',   'card'=>'bg-indigo-50',   'text'=>'text-indigo-800',   'sub'=>'text-indigo-500',   'border'=>'border-indigo-200',   'badge'=>'bg-indigo-100 text-indigo-700',  'glow'=>'shadow-indigo-100'],
        ['dot'=>'bg-violet-500',   'card'=>'bg-violet-50',   'text'=>'text-violet-800',   'sub'=>'text-violet-500',   'border'=>'border-violet-200',   'badge'=>'bg-violet-100 text-violet-700',  'glow'=>'shadow-violet-100'],
        ['dot'=>'bg-emerald-500',  'card'=>'bg-emerald-50',  'text'=>'text-emerald-800',  'sub'=>'text-emerald-600',  'border'=>'border-emerald-200',  'badge'=>'bg-emerald-100 text-emerald-700', 'glow'=>'shadow-emerald-100'],
        ['dot'=>'bg-amber-500',    'card'=>'bg-amber-50',    'text'=>'text-amber-800',    'sub'=>'text-amber-600',    'border'=>'border-amber-200',    'badge'=>'bg-amber-100 text-amber-700',     'glow'=>'shadow-amber-100'],
        ['dot'=>'bg-rose-500',     'card'=>'bg-rose-50',     'text'=>'text-rose-800',     'sub'=>'text-rose-500',     'border'=>'border-rose-200',     'badge'=>'bg-rose-100 text-rose-700',       'glow'=>'shadow-rose-100'],
        ['dot'=>'bg-cyan-500',     'card'=>'bg-cyan-50',     'text'=>'text-cyan-800',     'sub'=>'text-cyan-600',     'border'=>'border-cyan-200',     'badge'=>'bg-cyan-100 text-cyan-700',       'glow'=>'shadow-cyan-100'],
        ['dot'=>'bg-fuchsia-500',  'card'=>'bg-fuchsia-50',  'text'=>'text-fuchsia-800',  'sub'=>'text-fuchsia-500',  'border'=>'border-fuchsia-200',  'badge'=>'bg-fuchsia-100 text-fuchsia-700', 'glow'=>'shadow-fuchsia-100'],
        ['dot'=>'bg-teal-500',     'card'=>'bg-teal-50',     'text'=>'text-teal-800',     'sub'=>'text-teal-600',     'border'=>'border-teal-200',     'badge'=>'bg-teal-100 text-teal-700',       'glow'=>'shadow-teal-100'],
    ];
    $moduleColors = [];
    $ci = 0;
    foreach ($schedules as $s) {
        $name = $s->module->name;
        if (!isset($moduleColors[$name])) {
            $moduleColors[$name] = $palette[$ci % count($palette)];
            $ci++;
        }
    }

    $activeDays = $schedules->pluck('day')->unique()->toArray();
@endphp

<style>
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .animate-fade-slide-up { animation: fadeSlideUp 0.5s ease-out both; }
    .animate-delay-100 { animation-delay: 0.1s; }
    .animate-delay-200 { animation-delay: 0.2s; }
    .animate-delay-300 { animation-delay: 0.3s; }

    .schedule-card-hover {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .schedule-card-hover:hover {
        transform: translateY(-2px) scale(1.01);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
    }

    .today-glow {
        background: linear-gradient(180deg, rgba(99,102,241,0.06) 0%, rgba(99,102,241,0.02) 100%);
    }

    .today-col-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%);
        box-shadow: 0 4px 15px -3px rgba(99,102,241,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
    }

    .today-dot {
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34,197,94,0.2), 0 0 12px rgba(34,197,94,0.4);
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { box-shadow: 0 0 0 3px rgba(34,197,94,0.2), 0 0 12px rgba(34,197,94,0.4); }
        50%      { box-shadow: 0 0 0 6px rgba(34,197,94,0.1), 0 0 20px rgba(34,197,94,0.2); }
    }

    .summary-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -12px rgba(0,0,0,0.1);
    }

    .glass-badge {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    @media print {
        @page { size: landscape; margin: 12mm; }

        body * { visibility: hidden !important; }

        #print-area, #print-area * { visibility: visible !important; }
        #print-area {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            background: #fff !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #print-area .print-header {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        #print-area .print-title {
            font-size: 20px;
            font-weight: 900;
            color: #1e293b;
            margin: 0;
        }

        #print-area .print-filiere {
            font-size: 12px;
            font-weight: 700;
            color: #6366f1;
            margin: 2px 0 0 0;
        }

        #print-area .print-date {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 600;
        }

        #print-area .print-legend {
            display: flex !important;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 14px;
        }

        #print-area .print-legend-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            font-weight: 700;
            color: #475569;
            padding: 3px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #f8fafc;
        }

        #print-area .print-legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        #print-area table {
            display: table !important;
            width: 100% !important;
            border-collapse: collapse !important;
            border: 1px solid #e2e8f0 !important;
        }

        #print-area thead { display: table-header-group !important; }
        #print-area tbody { display: table-row-group !important; }
        #print-area tr { display: table-row !important; }

        #print-area th, #print-area td {
            display: table-cell !important;
            border: 1px solid #e2e8f0 !important;
        }

        #print-area th {
            background: #1e293b !important;
            color: #fff !important;
            font-size: 10px !important;
            font-weight: 800 !important;
            padding: 8px 6px !important;
            text-align: center !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #print-area th.today-print {
            background: #4f46e5 !important;
        }

        #print-area td {
            padding: 6px !important;
            vertical-align: top !important;
            font-size: 9px !important;
        }

        #print-area td.time-cell {
            background: #f8fafc !important;
            text-align: center !important;
            font-weight: 800 !important;
            color: #4f46e5 !important;
            width: 70px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #print-area td.today-print-col {
            background: #eef2ff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #print-area .course-card-print {
            border-radius: 6px !important;
            padding: 5px !important;
            border-left: 3px solid !important;
            box-shadow: none !important;
        }

        #print-area .course-name-print {
            font-size: 9px !important;
            font-weight: 900 !important;
            line-height: 1.3 !important;
            margin-bottom: 2px !important;
        }

        #print-area .course-detail-print {
            font-size: 8px !important;
            font-weight: 600 !important;
            line-height: 1.4 !important;
        }

        #print-area .empty-cell-print {
            text-align: center !important;
            color: #cbd5e1 !important;
            font-size: 10px !important;
        }

        #print-area .shadow-xl,
        #print-area .shadow-sm,
        #print-area .shadow-lg,
        #print-area .rounded-\[2rem\],
        #print-area .rounded-2xl { box-shadow: none !important; border-radius: 0 !important; }
    }
</style>

{{-- ═══════════════════════════════════════════════ PAGE HEADER --}}
<div class="mb-8 animate-fade-slide-up">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
        {{-- Title area --}}
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Emploi du temps</h2>
                <p class="text-slate-400 mt-0.5 text-sm font-medium">
                    Semaine en cours &bull;
                    @if(isset($student) && $student->filiere)
                        <span class="font-bold text-indigo-600">{{ $student->filiere->name }}</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Actions --}}
        @if(!$schedules->isEmpty())
        <div class="flex items-center gap-3 flex-wrap">
            {{-- Legend --}}
            <div class="flex flex-wrap gap-2">
                @foreach($moduleColors as $modName => $c)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold {{ $c['badge'] }} glass-badge border {{ $c['border'] }}">
                    <span class="w-2 h-2 rounded-full {{ $c['dot'] }}"></span>
                    {{ Str::limit($modName, 20) }}
                </span>
                @endforeach
            </div>

            {{-- Print button --}}
            <button onclick="window.print()" class="hidden-print inline-flex items-center gap-2.5 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all font-bold text-sm active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v7H6v-7z" />
                </svg>
                <span>Imprimer</span>
            </button>
        </div>
        @endif
    </div>
</div>

@if($schedules->isEmpty())
{{-- ═══════════════════════════════════════════════ EMPTY STATE --}}
<div class="text-center py-32 bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm animate-fade-slide-up">
    <div class="w-28 h-28 bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
    <h3 class="text-xl font-bold text-slate-400">Aucun cours planifié</h3>
    <p class="text-slate-300 mt-2 text-sm max-w-sm mx-auto">Votre emploi du temps n'a pas encore été configuré. Veuillez contacter l'administration.</p>
</div>

@else
{{-- ═══════════════════════════════════════════════ WEEKLY GRID --}}
<div id="print-area" class="animate-fade-slide-up animate-delay-100">
    {{-- Print-only header --}}
    <div class="print-header" style="display:none">
        <div>
            <p class="print-title">Emploi du Temps</p>
            @if(isset($student) && $student->filiere)
                <p class="print-filiere">{{ $student->filiere->name }}</p>
            @endif
        </div>
        <p class="print-date">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
    {{-- Print-only legend --}}
    <div class="print-legend" style="display:none">
        @php
            $legendColors = [
                'indigo-500' => '#6366f1', 'violet-500' => '#8b5cf6', 'emerald-500' => '#10b981',
                'amber-500' => '#f59e0b', 'rose-500' => '#f43f5e', 'cyan-500' => '#06b6d4',
                'fuchsia-500' => '#d946ef', 'teal-500' => '#14b8a6',
            ];
        @endphp
        @foreach($moduleColors as $modName => $c)
        <span class="print-legend-item">
            <span class="print-legend-dot" style="background: {{ $legendColors[str_replace('bg-', '', $c['dot'])] ?? '#6366f1' }}"></span>
            {{ $modName }}
        </span>
        @endforeach
    </div>

    <div id="schedule-print-area" class="overflow-x-auto rounded-[2rem] shadow-xl border border-slate-200/60 bg-white">
        <table class="w-full min-w-[800px] border-collapse">

            {{-- ── Column headers (days) ── --}}
            <thead>
                <tr>
                    {{-- Time column header --}}
                    <th class="w-28 px-4 py-5 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-400 text-xs font-black uppercase tracking-[0.2em] text-center border-r border-slate-700/50">
                        <div class="flex flex-col items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Horaire
                        </div>
                    </th>

                    @foreach($days as $day)
                    @php $isToday = ($day === $today); $hasAny = in_array($day, $activeDays); @endphp
                    <th class="px-3 py-5 text-center border-r border-slate-200/60 last:border-r-0
                        {{ $isToday
                            ? 'today-col-header today-print text-white'
                            : ($hasAny ? 'bg-slate-800 text-white' : 'bg-slate-800 text-slate-500') }}">
                        <div class="flex flex-col items-center gap-1">
                            <span class="text-sm font-black tracking-wide">{{ $day }}</span>
                            @if($isToday)
                                <span class="flex items-center gap-1.5 mt-0.5">
                                    <span class="today-dot w-2 h-2 rounded-full"></span>
                                    <span class="text-[10px] font-bold opacity-90 tracking-wide">Aujourd'hui</span>
                                </span>
                            @endif
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>

            {{-- ── Rows (time slots) ── --}}
            <tbody>
                @foreach($matrix as $slotKey => $dayMap)
                @php
                    [$slotStart, $slotEnd] = explode('|', $slotKey);
                    $isLastRow = ($loop->last);
                @endphp
                <tr class="group/row border-b border-slate-100 last:border-b-0 hover:bg-slate-50/50 transition-colors duration-200">

                    {{-- Time label cell --}}
                    <td class="time-cell px-4 py-4 border-r border-slate-100 bg-slate-50/80 text-center align-middle">
                        <div class="flex flex-col items-center">
                            <span class="text-lg font-black text-indigo-600 leading-none">{{ $slotStart }}</span>
                            <span class="text-[10px] text-slate-400 font-bold mt-1 tracking-wide">{{ $slotEnd }}</span>
                        </div>
                    </td>

                    {{-- Day cells --}}
                    @foreach($days as $dayIdx => $day)
                    @php
                        $course  = $dayMap[$day] ?? null;
                        $isToday = ($day === $today);
                        $isLast  = ($dayIdx === count($days) - 1);
                    @endphp
                    <td class="p-2.5 border-r border-slate-100/80 {{ $isLast ? 'border-r-0' : '' }}
                        {{ $isToday ? 'today-glow today-print-col' : 'bg-white' }}" style="min-width:135px;">

                        @if($course)
                        @php $c = $moduleColors[$course->module->name]; @endphp
                        <div class="schedule-card-hover course-card-print relative {{ $c['card'] }} border {{ $c['border'] }} rounded-2xl p-3.5 h-full cursor-default group/card overflow-hidden" style="border-left-width:3px">
                            {{-- Accent bar --}}
                            <div class="absolute left-0 top-2.5 bottom-2.5 w-[3px] rounded-r-full {{ $c['dot'] }}"></div>

                            {{-- Subtle background decoration --}}
                            <div class="absolute -right-3 -top-3 w-16 h-16 rounded-full {{ $c['dot'] }}" style="opacity:0.04"></div>

                            {{-- Module name --}}
                            <p class="course-name-print text-[11px] font-black {{ $c['text'] }} leading-snug pl-2.5 mb-2.5">{{ $course->module->name }}</p>

                            {{-- Details --}}
                            <div class="course-detail-print space-y-1 pl-2.5">
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $c['sub'] }} shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-[10px] font-bold {{ $c['sub'] }}">{{ $course->room->name }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $c['sub'] }} shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-[10px] font-bold {{ $c['sub'] }}">Pr. {{ $course->professor->last_name }}</span>
                                </div>
                            </div>
                        </div>

                        @else
                        {{-- Empty cell --}}
                        <div class="empty-cell-print min-h-[78px] rounded-2xl
                            {{ $isToday ? 'border border-dashed border-indigo-200/60 bg-indigo-50/30' : 'border border-dashed border-slate-100' }}
                            flex items-center justify-center transition-colors duration-200">
                            <span class="{{ $isToday ? 'text-indigo-200' : 'text-slate-200' }} text-sm select-none font-light">—</span>
                        </div>
                        @endif

                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ═══════════════════════════════════════════════ TODAY'S SUMMARY CARD --}}
@php
    $todayCourses = $schedules->where('day', $today)->sortBy('start_time');
@endphp
@if($todayCourses->isNotEmpty())
<div class="mt-10 animate-fade-slide-up animate-delay-200">
    {{-- Section header --}}
    <div class="flex items-center gap-3 mb-6">
        <div class="flex items-center gap-2">
            <span class="today-dot w-2.5 h-2.5 rounded-full"></span>
            <h3 class="text-lg font-black text-slate-800">Aujourd'hui</h3>
        </div>
        <span class="text-indigo-600 font-black text-lg">&middot;</span>
        <span class="text-lg font-black text-indigo-600">{{ $today }}</span>
        <div class="flex-1 h-px bg-gradient-to-r from-slate-200 to-transparent"></div>
        <span class="text-xs font-bold text-white bg-indigo-600 px-3 py-1.5 rounded-full shadow-sm">
            {{ $todayCourses->count() }} cours
        </span>
    </div>

    {{-- Course cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($todayCourses as $item)
        @php $c = $moduleColors[$item->module->name]; @endphp
        <div class="summary-card bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm relative overflow-hidden group">
            {{-- Top accent line --}}
            <div class="absolute top-0 left-0 right-0 h-1 {{ $c['dot'] }} rounded-t-2xl"></div>

            {{-- Background decoration --}}
            <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full {{ $c['dot'] }}" style="opacity:0.04"></div>

            {{-- Time + Room badge --}}
            <div class="flex items-center justify-between mb-3 mt-1">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl {{ $c['card'] }} flex items-center justify-center border {{ $c['border'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $c['sub'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-800">
                            {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
                            <span class="text-slate-400 mx-0.5">&ndash;</span>
                            {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                        </p>
                    </div>
                </div>
                <span class="text-[10px] font-black {{ $c['badge'] }} px-2.5 py-1 rounded-lg">{{ $item->room->name }}</span>
            </div>

            {{-- Module name --}}
            <h4 class="font-black text-slate-800 text-sm leading-snug mb-3">{{ $item->module->name }}</h4>

            {{-- Professor --}}
            <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                <div class="w-7 h-7 rounded-full {{ $c['card'] }} border {{ $c['border'] }} flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ $c['sub'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-600">Prof. {{ $item->professor->first_name }} {{ $item->professor->last_name }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

</div> {{-- end #print-area --}}

@endif {{-- end !empty --}}

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const exportBtn = document.getElementById('export-pdf-btn');
        if(!exportBtn) return;

        exportBtn.addEventListener('click', function(){
            const scheduleEl = document.getElementById('schedule-print-area');
            if(!scheduleEl) return;

            const tableEl = scheduleEl.querySelector('table');
            if(!tableEl) return;

            const opt = {
                margin:       8,
                filename:     `emploi_du_temps_${(document.querySelector('.text-sm.font-bold') ? document.querySelector('.text-sm.font-bold').innerText.replace(/\s+/g,'_') : 'etudiant')}.pdf`,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            const wrapper = document.createElement('div');
            const clonedTable = tableEl.cloneNode(true);
            wrapper.style.background = '#fff';
            wrapper.style.padding = '8px';
            wrapper.appendChild(clonedTable);
            wrapper.id = 'schedule-print-clone';
            document.body.appendChild(wrapper);

            html2pdf().set(opt).from(wrapper).save().then(() => {
                document.body.removeChild(wrapper);
            }).catch(() => {
                document.body.removeChild(wrapper);
            });
        });
    });
</script>

@endsection
