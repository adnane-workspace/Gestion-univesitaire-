@extends('layouts.admin-layout')

@section('title', 'Détails de la Filière')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.filieres.index') }}" class="btn btn-ghost mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $filiere->name }} ({{ $filiere->code }})</h1>
                <p class="text-slate-500 mt-1">Aperçu complet de la filière et de ses modules</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.filieres.edit', $filiere) }}" class="btn btn-secondary flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Infos Column -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Informations Générales</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Code</p>
                        <p class="text-slate-700 font-bold">{{ $filiere->code }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Durée</p>
                        <p class="text-slate-700 font-bold">{{ $filiere->duration_years }} ans</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Statut</p>
                        @if($filiere->is_active)
                            <span class="badge badge-success">
                                Active
                            </span>
                        @else
                            <span class="badge badge-neutral">
                                Inactive
                            </span>
                        @endif
                    </div>
                    @if($filiere->description)
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Description</p>
                        <p class="text-slate-600 text-sm leading-relaxed mt-1">{{ $filiere->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modules Column -->
        <div class="lg:col-span-2">
            <div class="card overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Modules de la Filière</h3>
                    <span class="badge badge-primary">
                        {{ $filiere->modules->count() }} Modules
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Code</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Module</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Crédits</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Semestre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filiere->modules as $module)
                            <tr>
                                <td class="px-6 py-4 font-mono text-sm text-indigo-600">{{ $module->code }}</td>
                                <td class="px-6 py-4 font-bold text-slate-700">{{ $module->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $module->credits }}</td>
                                <td class="px-6 py-4">
                                    <span class="badge badge-primary">S{{ $module->semester }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">
                                    Aucun module n'a encore été ajouté à cette filière.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
