@extends('layouts.dashboard')

@section('title', "QCM de {$module->name}")

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">QCM de révision</h1>
                <p class="text-sm text-slate-500 mt-2">Questions générées pour le module <strong>{{ $module->name }}</strong>.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('professeur.modules') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">Retour aux modules</a>
                <a href="{{ route('professeur.modules.qcm.attempts', ['module' => $module->id]) }}" class="inline-flex items-center justify-center rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-sm font-bold text-indigo-700 hover:bg-indigo-100 transition">Voir les tentatives</a>
                <form id="generateForm" class="inline-flex">
                    @csrf
                    <input type="hidden" name="num" value="10">
                    <input type="hidden" name="difficulty" value="moyen">
                    <button type="button" id="refreshQcm" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition">Régénérer le QCM</button>
                </form>
            </div>
        </div>

        @if(request()->query('mock'))
            <div class="rounded-lg p-3 bg-yellow-50 border border-yellow-200 text-yellow-900 font-semibold flex items-center gap-3">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-yellow-200 text-yellow-900">!</span>
                <div>
                    <div class="font-bold">Mode mock activé</div>
                    <div class="text-sm text-yellow-800">Ce QCM est généré en fallback, il utilise des données factices pour le développement.</div>
                </div>
            </div>
        @endif

        @if($questions->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                Aucun QCM généré pour ce module pour le moment. Cliquez sur "Régénérer le QCM" depuis cette page ou depuis la liste des modules.
            </div>
        @else
            <div class="space-y-6">
                @foreach($questions as $question)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <h2 class="text-lg font-bold text-slate-900">Question {{ $loop->iteration }}</h2>
                            @if($question->difficulty)
                                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ ucfirst($question->difficulty) }}</span>
                            @endif
                        </div>
                        <p class="mt-4 text-slate-700">{{ $question->text }}</p>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @extends('layouts.dashboard')

                            @section('title', "QCM — {$module->name}")

                            @section('content')
                                <div class="space-y-6">
                                    <!-- HERO / BANNER -->
                                    <div class="relative rounded-3xl p-6 overflow-hidden" style="background: linear-gradient(135deg,#0f172a 0%,#0b3b66 100%);">
                                        <div class="absolute inset-0 bg-white/5 backdrop-blur-md pointer-events-none"></div>
                                        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                            <div>
                                                <h1 class="text-2xl md:text-3xl font-extrabold text-white">Espace Professeur — {{ $module->name }}</h1>
                                                <p class="mt-1 text-sm text-white/80">QCM de révision générés pour ce module. Gestion et visualisation des tentatives.</p>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('professeur.modules') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 text-white text-sm font-semibold hover:bg-white/20 transition">Retour</a>
                                                <a href="{{ route('professeur.modules.qcm.attempts', ['module' => $module->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white text-indigo-700 text-sm font-semibold shadow-lg hover:scale-[1.02] transition">Voir tentatives</a>
                                                <button id="refreshQcm" class="inline-flex items-center gap-2 px-4 py-2 rounded-3xl bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold shadow-lg hover:scale-[1.02] transition">Régénérer QCM</button>
                                            </div>
                                        </div>

                                        <!-- Floating stat cards -->
                                        <div class="absolute left-6 right-6 -bottom-8 grid grid-cols-1 sm:grid-cols-4 gap-4 z-0">
                                            <div class="bg-white/8 backdrop-blur rounded-2xl p-4 shadow-md border border-white/10 hover:shadow-lg transition transform hover:-translate-y-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">👥</div>
                                                    <div>
                                                        <div class="text-sm text-white/80">Étudiants</div>
                                                        <div class="text-lg font-extrabold text-white">{{ $module->professors->first()->students_count ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-white/8 backdrop-blur rounded-2xl p-4 shadow-md border border-white/10 hover:shadow-lg transition transform hover:-translate-y-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">📚</div>
                                                    <div>
                                                        <div class="text-sm text-white/80">Modules</div>
                                                        <div class="text-lg font-extrabold text-white">{{ $module->filiere->modules()->count() ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-white/8 backdrop-blur rounded-2xl p-4 shadow-md border border-white/10 hover:shadow-lg transition transform hover:-translate-y-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">📝</div>
                                                    <div>
                                                        <div class="text-sm text-white/80">QCM</div>
                                                        <div class="text-lg font-extrabold text-white">{{ $module->questions()->count() }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-white/8 backdrop-blur rounded-2xl p-4 shadow-md border border-white/10 hover:shadow-lg transition transform hover:-translate-y-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">📈</div>
                                                    <div>
                                                        <div class="text-sm text-white/80">Taux réussite</div>
                                                        <div class="text-lg font-extrabold text-white">— %</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MAIN CONTENT -->
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                        <!-- Left: Questions list -->
                                        <div class="lg:col-span-2 space-y-6">
                                            @if(request()->query('mock'))
                                                <div class="rounded-lg p-3 bg-yellow-50 border border-yellow-200 text-yellow-900 font-semibold flex items-center gap-3">
                                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-yellow-200 text-yellow-900">!</span>
                                                    <div>
                                                        <div class="font-bold">Mode mock activé</div>
                                                        <div class="text-sm text-yellow-800">Ce QCM est généré en fallback, il utilise des données factices pour le développement.</div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($questions->isEmpty())
                                                <div class="rounded-3xl border border-dashed border-slate-200 bg-white/60 p-8 text-center text-slate-500">
                                                    Aucun QCM généré pour ce module pour le moment. Utilisez "Régénérer QCM" pour créer des questions.
                                                </div>
                                            @else
                                                <div class="space-y-4">
                                                    @foreach($questions as $question)
                                                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                                                            <div class="flex items-center justify-between">
                                                                <h3 class="text-lg font-bold text-slate-900">Question {{ $loop->iteration }}</h3>
                                                                @if($question->difficulty)
                                                                    <span class="text-xs font-semibold text-slate-500 bg-slate-50 px-3 py-1 rounded-full">{{ ucfirst($question->difficulty) }}</span>
                                                                @endif
                                                            </div>
                                                            <p class="mt-3 text-slate-700">{{ $question->text }}</p>

                                                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                                                @foreach($question->choices as $choice)
                                                                    <div class="rounded-2xl border p-4 text-sm flex items-start gap-3 {{ $choice->is_correct ? 'border-emerald-300 bg-emerald-50 text-emerald-800' : 'border-slate-200 bg-white' }}">
                                                                        <div class="w-3 h-3 rounded-full mt-1 {{ $choice->is_correct ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                                                        <div class="flex-1">{{ $choice->text }}</div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            @if($question->explanation)
                                                                <div class="mt-4 rounded-xl p-3 bg-slate-50 border border-slate-100 text-sm text-slate-600">{{ $question->explanation }}</div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Right: Sidebar widgets -->
                                        <aside class="space-y-4">
                                            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <div class="text-sm font-medium text-slate-500">Résumé QCM</div>
                                                        <div class="text-2xl font-extrabold text-slate-900">{{ $questions->count() }} Questions</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <div class="text-sm font-medium text-slate-500">Actions rapides</div>
                                                    </div>
                                                </div>
                                                <div class="mt-3 grid gap-2">
                                                    <a href="{{ route('professeur.modules.qcm.attempts', ['module' => $module->id]) }}" class="block text-center px-3 py-2 rounded-lg bg-indigo-600 text-white font-semibold">Voir les tentatives</a>
                                                    <button id="refreshQcmSide" class="block w-full px-3 py-2 rounded-lg bg-white border border-slate-100 text-slate-700 font-semibold">Régénérer QCM</button>
                                                </div>
                                            </div>
                                        </aside>
                                    </div>

                                </div>

                                <script>
                                    async function callGenerate() {
                                        const response = await fetch('{{ route('professeur.modules.generate-qcm', ['module' => $module->id]) }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ num: 10, difficulty: 'moyen' })
                                        });

                                        if (!response.ok) {
                                            const error = await response.json().catch(() => null);
                                            alert(error?.error || 'Erreur lors de la génération du QCM.');
                                            return;
                                        }

                                        const payload = await response.json().catch(() => null);
                                        if (payload && payload.redirect) {
                                            let url = payload.redirect;
                                            if (payload.mock) {
                                                url += (url.includes('?') ? '&' : '?') + 'mock=1';
                                            }
                                            window.location.href = url;
                                        } else {
                                            window.location.reload();
                                        }
                                    }

                                    document.getElementById('refreshQcm')?.addEventListener('click', callGenerate);
                                    document.getElementById('refreshQcmSide')?.addEventListener('click', callGenerate);
                                </script>
                            @endsection
