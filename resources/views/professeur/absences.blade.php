@extends('layouts.dashboard')

@section('title', 'Gestion des Absences')

@section('sidebar-links')
    <a href="{{ route('professeur.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.dashboard') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Tableau de bord
    </a>
    <a href="{{ route('professeur.modules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.modules') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Mes Modules
    </a>
    <a href="{{ route('professeur.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.grades') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Saisie des Notes
    </a>
    <a href="{{ route('professeur.absences') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.absences') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Absences
    </a>
    <a href="{{ route('professeur.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('professeur.schedule') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-5 p-5 md:flex-row md:items-center md:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-widest text-indigo-600">Espace professeur</p>
                <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-950">Gestion des absences</h2>
                <p class="mt-1 text-sm text-slate-500">Choisissez une s&eacute;ance, cochez les absents, puis enregistrez la feuille d'appel.</p>
            </div>
            <a href="{{ route('professeur.dashboard') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                Retour au tableau de bord
            </a>
        </div>
        @if($schedule)
            <div class="grid border-t border-slate-100 bg-slate-50 md:grid-cols-3">
                <div class="border-b border-slate-100 p-4 md:border-b-0 md:border-r">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Module</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">{{ $schedule->module?->name ?? 'Module non renseigne' }}</p>
                </div>
                <div class="border-b border-slate-100 p-4 md:border-b-0 md:border-r">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Date et heure</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">{{ $schedule->date?->format('d/m/Y') ?? $schedule->day }} &bull; {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</p>
                </div>
                <div class="p-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Salle</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">{{ $schedule->room?->name ?? 'Salle non renseignee' }}</p>
                </div>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-8 rounded-3xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 rounded-3xl border border-rose-200 bg-rose-50 p-5 text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form action="{{ route('professeur.absences') }}" method="GET" class="grid grid-cols-1 gap-5 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">S&eacute;ance</label>
                <select name="schedule_id" onchange="this.form.submit()" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-100">
                    <option value="">S&eacute;lectionnez une s&eacute;ance</option>
                    @foreach($schedules as $scheduleItem)
                        <option value="{{ $scheduleItem->id }}" {{ $selectedScheduleId == $scheduleItem->id ? 'selected' : '' }}>
                            {{ $scheduleItem->date?->format('d/m/Y') ?? $scheduleItem->day }} &bull; {{ \Carbon\Carbon::parse($scheduleItem->start_time)->format('H:i') }} - {{ $scheduleItem->module?->name ?? 'Module non renseigne' }} &bull; {{ $scheduleItem->room?->name ?? 'Salle non renseignee' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-slate-700">
                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">S&eacute;ance active</p>
                @if($schedule)
                    <p class="mt-2 text-sm font-semibold text-slate-800">{{ $schedule->module?->name ?? 'Module non renseigne' }}</p>
                    <p class="text-sm text-slate-500">{{ $schedule->date?->format('d/m/Y') ?? $schedule->day }} &bull; {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</p>
                @else
                    <p class="mt-3 text-slate-400">Choisissez une s&eacute;ance pour afficher les &eacute;tudiants.</p>
                @endif
            </div>
        </form>
    </div>

    @if($selectedScheduleId && $schedule)
        <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Total &eacute;tudiants</p>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-slate-950">{{ $students->count() }}</p>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-rose-500">Absents</p>
                <p id="absent-count" class="mt-2 text-4xl font-semibold tracking-tight text-rose-600">{{ $absences->count() }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Pr&eacute;sents</p>
                <p id="present-count" class="mt-2 text-4xl font-semibold tracking-tight text-emerald-700">{{ max($students->count() - $absences->count(), 0) }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Actions rapides</p>
                <div class="mt-3 grid grid-cols-2 gap-2 xl:grid-cols-1">
                    <button type="button" id="mark-all-absent" class="inline-flex items-center justify-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                        <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                        Absents
                    </button>
                    <button type="button" id="mark-all-present" class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Pr&eacute;sents
                    </button>
                </div>
            </div>
        </div>

        @if($students->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-16 text-center text-slate-500">
                <p class="text-xl font-bold">Aucun &eacute;tudiant trouv&eacute; pour cette fili&egrave;re.</p>
                <p class="mt-3">V&eacute;rifiez que la s&eacute;ance est bien rattach&eacute;e &agrave; un module et &agrave; une fili&egrave;re.</p>
            </div>
        @else
            <form action="{{ route('professeur.absences.store') }}" method="POST">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div class="relative flex-1">
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z" />
                                </svg>
                            </span>
                            <input id="student-search" type="search" placeholder="Rechercher un &eacute;tudiant, CIN ou fili&egrave;re" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-100" />
                        </div>
                        <div class="inline-flex w-fit rounded-xl border border-slate-200 bg-slate-100 p-1" role="group" aria-label="Filtres absences">
                            <button type="button" data-filter="all" class="absence-filter rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm transition">Tous</button>
                            <button type="button" data-filter="absent" class="absence-filter rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 transition hover:text-slate-900">Absents</button>
                            <button type="button" data-filter="present" class="absence-filter rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 transition hover:text-slate-900">Pr&eacute;sents</button>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-slate-400"><span id="visible-count">{{ $students->count() }}</span> &eacute;tudiants affich&eacute;s</p>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <table class="w-full min-w-[900px] text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-widest text-slate-500">
                            <tr>
                                <th class="px-6 py-4">&Eacute;tudiant</th>
                                <th class="px-6 py-4">Statut</th>
                                <th class="px-6 py-4">Motif</th>
                                <th class="px-6 py-4">Justifi&eacute;</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($students as $student)
                                @php
                                    $absence = $absences->get($student->id);
                                @endphp
                                <tr class="absence-row transition-colors hover:bg-slate-50 {{ $absence ? 'bg-rose-50/50' : '' }}" data-student="{{ Str::lower($student->first_name . ' ' . $student->last_name . ' ' . ($student->student_id_number ?? '') . ' ' . ($student->filiere?->name ?? '')) }}" data-status="{{ $absence ? 'absent' : 'present' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-sm font-semibold text-slate-600 ring-1 ring-slate-200">
                                                {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-slate-900">{{ $student->first_name }} {{ $student->last_name }}</div>
                                                <div class="text-xs text-slate-400">{{ $student->student_id_number ?? 'N/A' }} &bull; {{ $student->filiere?->name ?? 'Filiere inconnue' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                                            <input type="checkbox" name="absent[{{ $student->id }}]" value="1" {{ $absence ? 'checked' : '' }} class="absence-checkbox h-5 w-5 rounded-xl border-slate-300 text-indigo-600" />
                                            <span class="absence-status-pill rounded-full px-2.5 py-1 text-xs font-semibold {{ $absence ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $absence ? 'Absent' : 'Pr&eacute;sent' }}</span>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="reason[{{ $student->id }}]" value="{{ old('reason.'.$student->id, $absence->reason ?? '') }}" placeholder="Ex: Maladie, rendez-vous" class="absence-reason w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 outline-none transition disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-100" {{ $absence ? '' : 'disabled' }} />
                                    </td>
                                    <td class="px-6 py-4">
                                        <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                                            <input type="checkbox" name="excused[{{ $student->id }}]" value="1" {{ optional($absence)->excused ? 'checked' : '' }} {{ $absence ? '' : 'disabled' }} class="absence-excused h-5 w-5 rounded-xl border-slate-300 text-emerald-600" />
                                            <span>Oui</span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="sticky bottom-4 z-10 mt-6 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-xl md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Feuille d'appel pr&ecirc;te &agrave; enregistrer</p>
                        <p class="text-sm text-slate-500">Les &eacute;tudiants non coch&eacute;s seront consid&eacute;r&eacute;s comme pr&eacute;sents.</p>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700">Enregistrer les absences</button>
                </div>
            </form>
        @endif
    @elseif($selectedScheduleId)
        <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-16 text-center text-slate-500">
            <p class="text-xl font-bold">S&eacute;ance introuvable ou non autoris&eacute;e.</p>
            <p class="mt-3">Veuillez s&eacute;lectionner une s&eacute;ance valide.</p>
        </div>
    @else
        <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-16 text-center text-slate-500">
            <p class="text-xl font-bold">Aucune s&eacute;ance s&eacute;lectionn&eacute;e.</p>
            <p class="mt-3">Choisissez la s&eacute;ance de cours pour afficher la liste des &eacute;tudiants et g&eacute;rer les absences.</p>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = Array.from(document.querySelectorAll('.absence-checkbox'));
            const absentCountEl = document.getElementById('absent-count');
            const presentCountEl = document.getElementById('present-count');
            const visibleCountEl = document.getElementById('visible-count');
            const searchInput = document.getElementById('student-search');
            const filterButtons = Array.from(document.querySelectorAll('.absence-filter'));
            const markAllAbsent = document.getElementById('mark-all-absent');
            const markAllPresent = document.getElementById('mark-all-present');
            let activeFilter = 'all';

            const updateRow = function (checkbox) {
                const row = checkbox.closest('tr');
                const reason = row.querySelector('.absence-reason');
                const excused = row.querySelector('.absence-excused');
                const statusPill = row.querySelector('.absence-status-pill');
                const active = checkbox.checked;

                if (reason) {
                    reason.disabled = !active;
                    reason.classList.toggle('bg-slate-50', !active);
                    reason.classList.toggle('bg-white', active);
                }

                if (excused) {
                    excused.disabled = !active;
                }

                row.classList.toggle('bg-rose-50/50', active);
                row.dataset.status = active ? 'absent' : 'present';

                if (statusPill) {
                    statusPill.textContent = active ? 'Absent' : 'Présent';
                    statusPill.classList.toggle('bg-rose-100', active);
                    statusPill.classList.toggle('text-rose-700', active);
                    statusPill.classList.toggle('bg-emerald-100', !active);
                    statusPill.classList.toggle('text-emerald-700', !active);
                }
            };

            const updateCount = function () {
                const count = checkboxes.filter(function (checkbox) {
                    return checkbox.checked;
                }).length;

                if (absentCountEl) {
                    absentCountEl.textContent = count;
                }
                if (presentCountEl) {
                    presentCountEl.textContent = Math.max(checkboxes.length - count, 0);
                }
            };

            const applyFilters = function () {
                const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
                let visibleCount = 0;

                document.querySelectorAll('.absence-row').forEach(function (row) {
                    const matchesSearch = !query || row.dataset.student.includes(query);
                    const matchesStatus = activeFilter === 'all' || row.dataset.status === activeFilter;
                    const visible = matchesSearch && matchesStatus;
                    row.classList.toggle('hidden', !visible);
                    if (visible) {
                        visibleCount += 1;
                    }
                });

                if (visibleCountEl) {
                    visibleCountEl.textContent = visibleCount;
                }
            };

            checkboxes.forEach(function (checkbox) {
                updateRow(checkbox);
                checkbox.addEventListener('change', function () {
                    updateRow(checkbox);
                    updateCount();
                    applyFilters();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', applyFilters);
            }

            filterButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    activeFilter = button.dataset.filter;
                    filterButtons.forEach(function (item) {
                        const active = item === button;
                        item.classList.toggle('bg-white', active);
                        item.classList.toggle('text-slate-900', active);
                        item.classList.toggle('shadow-sm', active);
                        item.classList.toggle('text-slate-500', !active);
                    });
                    applyFilters();
                });
            });

            if (markAllAbsent) {
                markAllAbsent.addEventListener('click', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = true;
                        checkbox.dispatchEvent(new Event('change'));
                    });
                });
            }

            if (markAllPresent) {
                markAllPresent.addEventListener('click', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = false;
                        checkbox.dispatchEvent(new Event('change'));
                    });
                });
            }

            updateCount();
            applyFilters();
        });
    </script>
@endsection
