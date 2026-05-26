@extends('layouts.dashboard')

@section('title', 'Mon Emploi du Temps')

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

@php
    $days        = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $today       = ucfirst(\Carbon\Carbon::now()->locale('fr')->dayName);

    // Build sorted unique time-slot keys: "08:30-10:00"
    $timeSlots = $schedules->map(function($s) {
        return \Carbon\Carbon::parse($s->start_time)->format('H:i')
             . '|'
             . \Carbon\Carbon::parse($s->end_time)->format('H:i');
    })->unique()->sort()->values();

    // Build matrix [timeKey][day] = schedule item
    $matrix = [];
    foreach ($schedules as $s) {
        $key = \Carbon\Carbon::parse($s->start_time)->format('H:i')
             . '|'
             . \Carbon\Carbon::parse($s->end_time)->format('H:i');
        $matrix[$key][$s->day] = $s;
    }
    ksort($matrix);

    // Assign a consistent color to each unique module
    $palette = [
        ['dot'=>'bg-indigo-500',   'card'=>'bg-indigo-50',   'text'=>'text-indigo-800',   'sub'=>'text-indigo-500',   'border'=>'border-indigo-200',   'badge'=>'bg-indigo-100 text-indigo-700'],
        ['dot'=>'bg-violet-500',   'card'=>'bg-violet-50',   'text'=>'text-violet-800',   'sub'=>'text-violet-500',   'border'=>'border-violet-200',   'badge'=>'bg-violet-100 text-violet-700'],
        ['dot'=>'bg-emerald-500',  'card'=>'bg-emerald-50',  'text'=>'text-emerald-800',  'sub'=>'text-emerald-600',  'border'=>'border-emerald-200',  'badge'=>'bg-emerald-100 text-emerald-700'],
        ['dot'=>'bg-amber-500',    'card'=>'bg-amber-50',    'text'=>'text-amber-800',    'sub'=>'text-amber-600',    'border'=>'border-amber-200',    'badge'=>'bg-amber-100 text-amber-700'],
        ['dot'=>'bg-rose-500',     'card'=>'bg-rose-50',     'text'=>'text-rose-800',     'sub'=>'text-rose-500',     'border'=>'border-rose-200',     'badge'=>'bg-rose-100 text-rose-700'],
        ['dot'=>'bg-cyan-500',     'card'=>'bg-cyan-50',     'text'=>'text-cyan-800',     'sub'=>'text-cyan-600',     'border'=>'border-cyan-200',     'badge'=>'bg-cyan-100 text-cyan-700'],
        ['dot'=>'bg-fuchsia-500',  'card'=>'bg-fuchsia-50',  'text'=>'text-fuchsia-800',  'sub'=>'text-fuchsia-500',  'border'=>'border-fuchsia-200',  'badge'=>'bg-fuchsia-100 text-fuchsia-700'],
        ['dot'=>'bg-teal-500',     'card'=>'bg-teal-50',     'text'=>'text-teal-800',     'sub'=>'text-teal-600',     'border'=>'border-teal-200',     'badge'=>'bg-teal-100 text-teal-700'],
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

    // Days that actually have courses (to filter empty columns)
    $activeDays = $schedules->pluck('day')->unique()->toArray();
@endphp

{{-- ═══════════════════════════════════════════════ PAGE HEADER --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Emploi du temps</h2>
        <p class="text-slate-500 mt-1 text-sm font-medium">
            Semaine en cours &bull;
            @if(isset($student) && $student->filiere)
                <span class="font-semibold text-indigo-600">{{ $student->filiere->name }}</span>
            @endif
        </p>
    </div>

    {{-- Legend + Print button --}}
    @if(!$schedules->isEmpty())
    <div class="flex items-center gap-4">
        <div class="flex flex-wrap gap-2">
            @foreach($moduleColors as $modName => $c)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $c['badge'] }}">
                <span class="w-2 h-2 rounded-full {{ $c['dot'] }}"></span>
                {{ Str::limit($modName, 24) }}
            </span>
            @endforeach
        </div>

        <button id="print-schedule-btn" onclick="window.print()" class="ml-2 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-sm hidden-print">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v7H6v-7z" />
            </svg>
            <span class="font-bold text-sm">Imprimer</span>
        </button>
    </div>
    @endif
</div>

@if($schedules->isEmpty())
{{-- ═══════════════════════════════════════════════ EMPTY STATE --}}
<div class="text-center py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100">
    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
    <h3 class="text-xl font-bold text-slate-400">Aucun cours planifié</h3>
    <p class="text-slate-300 mt-2 text-sm">Votre emploi du temps n'a pas encore été généré par l'administration.</p>
</div>

@else
{{-- ═══════════════════════════════════════════════ WEEKLY GRID --}}
<div id="schedule-print-area" class="overflow-x-auto rounded-3xl shadow-lg border border-slate-100">
    <table class="w-full min-w-[760px] border-collapse bg-white">

        {{-- ── Column headers (days) ── --}}
        <thead>
            <tr>
                {{-- Time column header --}}
                <th class="w-28 px-4 py-4 bg-gradient-to-br from-slate-800 to-slate-900 text-slate-300 text-xs font-bold uppercase tracking-widest text-center border-r border-slate-700 rounded-tl-3xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto mb-1 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Horaire
                </th>

                @foreach($days as $day)
                @php $isToday = ($day === $today); $hasAny = in_array($day, $activeDays); @endphp
                <th class="px-3 py-4 text-center text-sm font-black border-r border-slate-100 last:border-r-0 last:rounded-tr-3xl
                    {{ $isToday
                        ? 'bg-gradient-to-b from-indigo-600 to-indigo-700 text-white shadow-inner'
                        : ($hasAny ? 'bg-gradient-to-br from-slate-800 to-slate-900 text-slate-200' : 'bg-gradient-to-br from-slate-800 to-slate-900 text-slate-500') }}">
                    {{ $day }}
                    @if($isToday)
                        <span class="flex items-center justify-center gap-1 mt-1">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                            </span>
                            <span class="text-[10px] font-semibold opacity-90">Aujourd'hui</span>
                        </span>
                    @endif
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
            <tr class="border-b border-slate-100 {{ $isLastRow ? 'last:border-b-0' : '' }}">

                {{-- Time label cell --}}
                <td class="px-4 py-3 border-r border-slate-100 bg-slate-50 text-center {{ $isLastRow ? 'rounded-bl-3xl' : '' }}">
                    <span class="block text-base font-black text-indigo-600 leading-none">{{ $slotStart }}</span>
                    <span class="block text-xs text-slate-400 font-semibold mt-1">{{ $slotEnd }}</span>
                </td>

                {{-- Day cells --}}
                @foreach($days as $dayIdx => $day)
                @php
                    $course  = $dayMap[$day] ?? null;
                    $isToday = ($day === $today);
                    $isLast  = ($dayIdx === count($days) - 1);
                @endphp
                <td class="p-2 border-r border-slate-100 {{ $isLast ? 'border-r-0' : '' }} {{ $isLast && $isLastRow ? 'rounded-br-3xl' : '' }}
                    {{ $isToday ? 'bg-indigo-50/40' : 'bg-white' }}" style="min-width:130px;">

                    @if($course)
                    @php $c = $moduleColors[$course->module->name]; @endphp
                    <div class="group relative {{ $c['card'] }} {{ $c['border'] }} border rounded-2xl p-3 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-default h-full">
                        {{-- Colored left accent --}}
                        <div class="absolute left-0 top-3 bottom-3 w-1 rounded-r-full {{ $c['dot'] }}"></div>

                        {{-- Module name --}}
                        <p class="text-xs font-black {{ $c['text'] }} leading-snug pl-2 mb-2">{{ $course->module->name }}</p>

                        {{-- Room --}}
                        <div class="flex items-center gap-1 pl-2 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $c['sub'] }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-[11px] font-semibold {{ $c['sub'] }}">{{ $course->room->name }}</span>
                        </div>

                        {{-- Professor --}}
                        <div class="flex items-center gap-1 pl-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $c['sub'] }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-[11px] font-semibold {{ $c['sub'] }}">Pr. {{ $course->professor->last_name }}</span>
                        </div>
                    </div>

                    @else
                    {{-- Empty cell --}}
                    <div class="min-h-[80px] rounded-2xl
                        {{ $isToday ? 'border border-dashed border-indigo-200 bg-indigo-50/20' : 'border border-dashed border-slate-100' }}
                        flex items-center justify-center">
                        <span class="{{ $isToday ? 'text-indigo-200' : 'text-slate-200' }} text-xs select-none">—</span>
                    </div>
                    @endif

                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ═══════════════════════════════════════════════ TODAY'S SUMMARY CARD --}}
@php
    $todayCourses = $schedules->where('day', $today)->sortBy('start_time');
@endphp
@if($todayCourses->isNotEmpty())
<div class="mt-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
        <h3 class="text-lg font-black text-slate-800">Aujourd'hui · <span class="text-indigo-600">{{ $today }}</span></h3>
        <div class="flex-1 h-px bg-slate-100"></div>
        <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">{{ $todayCourses->count() }} cours</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($todayCourses as $item)
        @php $c = $moduleColors[$item->module->name]; @endphp
        <div class="bg-white rounded-2xl border {{ $c['border'] }} p-5 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full opacity-5 {{ $c['dot'] }}"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full {{ $c['dot'] }} shadow-sm"></span>
                    <span class="text-xs font-black {{ $c['text'] }} uppercase tracking-wider">
                        {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                    </span>
                </div>
                <span class="text-[10px] font-bold {{ $c['badge'] }} px-2 py-0.5 rounded-full">{{ $item->room->name }}</span>
            </div>
            <h4 class="font-black text-slate-800 text-sm leading-snug mb-2">{{ $item->module->name }}</h4>
            <p class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ $c['sub'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Prof. {{ $item->professor->first_name }} {{ $item->professor->last_name }}
            </p>
        </div>
        @endforeach
    </div>
</div>
@endif

@endif {{-- end !empty --}}

{{-- Print styles: show only the timetable table when printing --}}
<style>
    @media print {
        @page { size: landscape; margin: 10mm; }

        /* Hide everything visually by default (use visibility to allow targeted overrides) */
        body * { visibility: hidden !important; }

        /* Make the schedule area and its descendants visible */
        #schedule-print-area, #schedule-print-area * { visibility: visible !important; }

        /* Ensure the schedule container is positioned and full width */
        #schedule-print-area { position: absolute !important; left: 0 !important; top: 0 !important; width: 100% !important; background: #fff !important; padding: 0 !important; margin: 0 !important; }

        /* Table elements must be displayed as table for proper layout */
        #schedule-print-area table { display: table !important; width: 100% !important; border-collapse: collapse !important; }
        #schedule-print-area thead { display: table-header-group !important; }
        #schedule-print-area tbody { display: table-row-group !important; }
        #schedule-print-area tr { display: table-row !important; }
        #schedule-print-area th, #schedule-print-area td { display: table-cell !important; }

        /* Remove shadows/rounded corners for print clarity */
        #schedule-print-area .shadow-lg, #schedule-print-area .shadow-sm, #schedule-print-area .rounded-3xl { box-shadow: none !important; border-radius: 0 !important; }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const exportBtn = document.getElementById('export-pdf-btn');
        if(!exportBtn) return;

        exportBtn.addEventListener('click', function(){
            const scheduleEl = document.getElementById('schedule-print-area');
            if(!scheduleEl) return;

            // Export only the timetable table to PDF (exclude header/legend/summary)
            const tableEl = scheduleEl.querySelector('table');
            if(!tableEl) return;

            const opt = {
                margin:       8,
                filename:     `emploi_du_temps_${(document.querySelector('.text-sm.font-bold') ? document.querySelector('.text-sm.font-bold').innerText.replace(/\s+/g,'_') : 'etudiant')}.pdf`,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            // Clone only the table to avoid including other UI parts
            const wrapper = document.createElement('div');
            const clonedTable = tableEl.cloneNode(true);
            // Make sure clone fills the page
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
