@extends('layouts.dashboard')

@section('title', "QCM: {$module->name}")

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Révision QCM - {{ $module->name }}</h1>
                <p class="text-sm text-slate-500 mt-2">Répondez aux questions puis enregistrez votre note.</p>
            </div>
            <a href="{{ route('etudiant.modules') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">Retour aux modules</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-900 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-rose-900 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if($questions->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                Aucun QCM n'a encore été généré pour ce module. Demandez au professeur de générer le QCM depuis l'espace professeur.
            </div>
        @else
            <form method="POST" action="{{ route('etudiant.modules.qcm.submit', ['module' => $module->id]) }}">
                @csrf

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
                                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 cursor-pointer transition hover:border-indigo-300">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300" />
                                        <span class="text-sm text-slate-700">{{ $choice->text }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if($question->explanation)
                                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                    <strong>Conseil :</strong> {{ $question->explanation }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-6">
                    <div class="text-sm text-slate-500">Total de questions : <strong>{{ $questions->count() }}</strong></div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition">Valider et enregistrer ma note</button>
                </div>
            </form>
        @endif
    </div>
@endsection
