@extends('layouts.dashboard')

@section('title', "Tentative #{$attempt->id} — {$module->name}")

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tentative de {{ $attempt->student->getFullNameAttribute() ?? $attempt->student->first_name . ' ' . $attempt->student->last_name }}</h1>
                <p class="text-sm text-slate-500 mt-2">Score : <strong>{{ $attempt->score }} / {{ $attempt->max_score }}</strong></p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('professeur.modules.qcm.attempts', ['module' => $module->id]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Retour aux tentatives</a>
                <a href="{{ route('professeur.modules') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Retour aux modules</a>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($attempt->answers as $index => $ans)
                <div class="rounded-2xl border p-4 bg-white">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 pr-4">
                            <div class="text-sm text-slate-500">Question {{ $index + 1 }}</div>
                            <div class="mt-2 text-slate-700">{{ $ans->question->text }}</div>
                        </div>
                        <div class="text-right">
                            @if($ans->is_correct)
                                <div class="text-emerald-600 font-black">Correct</div>
                            @else
                                <div class="text-rose-600 font-black">Incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                        @foreach($ans->question->choices as $choice)
                            <div class="p-3 rounded-xl border {{ $choice->is_correct ? 'border-emerald-300 bg-emerald-50' : 'border-slate-100 bg-slate-50' }}">
                                <div class="flex items-center gap-2">
                                    <div class="text-sm">{{ $choice->text }}</div>
                                    @if($ans->selected_choice_id === $choice->id)
                                        <div class="ml-auto text-xs px-2 py-1 rounded-md bg-indigo-600 text-white font-bold">Sélectionné</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($ans->question->explanation)
                        <div class="mt-3 text-sm text-slate-600 bg-slate-50 p-3 rounded-md border border-slate-100">{{ $ans->question->explanation }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
