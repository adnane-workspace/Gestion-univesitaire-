@extends('layouts.admin-layout')

@section('title', 'Nouvelle Salle')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.rooms.index') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Nouvelle Salle</h1>
        <p class="text-slate-500 mt-1">Ajouter une nouvelle salle ou un amphithéâtre</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nom de la salle</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="ex: Salle 101, Amphi A"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-slate-700 mb-2">Code unique</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required placeholder="ex: S101"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 mb-2">Type de salle</label>
                    <select id="type" name="type" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                        @foreach(\App\Models\Room::TYPES as $key => $label)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-slate-700 mb-2">Capacité (places)</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', 30) }}" required min="1" max="500"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" checked class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Disponible immédiatement</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="building" class="block text-sm font-medium text-slate-700 mb-2">Bâtiment</label>
                    <input type="text" id="building" name="building" value="{{ old('building') }}" placeholder="ex: Bloc B"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('building')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="floor" class="block text-sm font-medium text-slate-700 mb-2">Étage</label>
                    <input type="number" id="floor" name="floor" value="{{ old('floor', 0) }}" required min="0" max="20"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    @error('floor')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow-md transition-all">
                    Créer la salle
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="text-slate-600 hover:text-slate-800 px-6 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
