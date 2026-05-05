@extends('layouts.admin-layout')

@section('title', 'Tableau de Bord Administrateur')

@section('content')
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Tableau de Bord</h1>
        <p class="text-slate-500 mt-1">Vue d'ensemble de l'université</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Étudiants -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold {{ $stats['students_growth'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $stats['students_growth'] >= 0 ? '↑' : '↓' }} {{ abs($stats['students_growth']) }}%
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['students_count'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Étudiants Inscrits</p>
        </div>

        <!-- Professeurs -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['professors_count'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Professeurs</p>
        </div>

        <!-- Filières -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full">Actives</span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['filieres_count'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Filières</p>
        </div>

        <!-- Salles -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-600">Disponibles</span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['rooms_available'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Salles Libres</p>
        </div>
    </div>

    <!-- Recent Students Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Derniers Étudiants Inscrits
            </h3>
            <a href="{{ route('admin.students.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                Voir tout →
            </a>
        </div>
        
        <div class="p-6">
            @if($recent_students->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Étudiant</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Matricule</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recent_students as $student)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                                {{ substr($student->first_name, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-slate-800">{{ $student->first_name }} {{ $student->last_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 text-sm">{{ $student->email }}</td>
                                    <td class="px-4 py-3 text-slate-600 font-mono text-sm">{{ $student->student_id_number }}</td>
                                    <td class="px-4 py-3 text-slate-500 text-sm">{{ $student->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">Aucun étudiant inscrit</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('admin.students.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span class="font-medium">Nouvel étudiant</span>
        </a>
        
        <a href="{{ route('admin.professors.create') }}" class="bg-white hover:bg-slate-50 text-slate-700 p-4 rounded-xl shadow-sm hover:shadow-md transition-all border border-slate-200 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span class="font-medium">Nouveau professeur</span>
        </a>
        
        <a href="{{ route('admin.filieres.create') }}" class="bg-white hover:bg-slate-50 text-slate-700 p-4 rounded-xl shadow-sm hover:shadow-md transition-all border border-slate-200 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span class="font-medium">Nouvelle filière</span>
        </a>
    </div>
@endsection
