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
                            @foreach($question->choices as $choice)
                                <div class="rounded-2xl border p-4 text-sm {{ $choice->is_correct ? 'border-emerald-400 bg-emerald-50 text-emerald-900' : 'border-slate-200 bg-slate-50 text-slate-700' }}">
                                    {{ $choice->text }}
                                </div>
                            @endforeach
                        </div>
                        @if($question->explanation)
                            <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                <strong>Explication :</strong> {{ $question->explanation }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.getElementById('refreshQcm').addEventListener('click', async function () {
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
        });
    </script>
@endsection
