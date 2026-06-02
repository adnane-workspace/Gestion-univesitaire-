@extends('layouts.dashboard')

@section('title', "Tentatives QCM: {$module->name}")

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tentatives QCM - {{ $module->name }}</h1>
                <p class="text-sm text-slate-500 mt-2">Liste des tentatives des étudiants pour ce module.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('professeur.modules.qcm', ['module' => $module->id]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Voir QCM</a>
                <a href="{{ route('professeur.modules') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Retour aux modules</a>
            </div>
        </div>

        @if($attempts->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                Aucun étudiant n'a encore passé ce QCM.
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-2xl border border-slate-100 p-4">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-slate-500 uppercase text-xs">
                            <th class="px-3 py-2">Étudiant</th>
                            <th class="px-3 py-2">Score</th>
                            <th class="px-3 py-2">Correct</th>
                            <th class="px-3 py-2">Questions</th>
                            <th class="px-3 py-2">Date</th>
                            <th class="px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($attempts as $attempt)
                            <tr>
                                <td class="px-3 py-3">{{ $attempt->student->getFullNameAttribute() ?? $attempt->student->first_name . ' ' . $attempt->student->last_name }}</td>
                                <td class="px-3 py-3 font-black">{{ $attempt->score }} / {{ $attempt->max_score }}</td>
                                <td class="px-3 py-3">{{ $attempt->correct_count }}</td>
                                <td class="px-3 py-3">{{ $attempt->question_count }}</td>
                                <td class="px-3 py-3">{{ $attempt->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-3 py-3">
                                    <a href="{{ route('professeur.modules.qcm.attempts.show', ['module' => $module->id, 'attempt' => $attempt->id]) }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold">Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
