@extends('layouts.admin-layout')

@section('title', 'Détails de la Filière')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.filieres.index') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $filiere->name }} ({{ $filiere->code }})</h1>
                <p class="text-slate-500 mt-1">Aperçu complet de la filière et de ses modules</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.filieres.edit', $filiere) }}" class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
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
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
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
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Modules de la Filière</h3>
                    <span class="text-xs font-bold px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg">
                        {{ $filiere->modules->count() }} Modules
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Code</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Module</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Crédits</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Semestre</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($filiere->modules as $module)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-indigo-600">{{ $module->code }}</td>
                                <td class="px-6 py-4 font-bold text-slate-700">{{ $module->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $module->credits }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-md">S{{ $module->semester }}</span>
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
