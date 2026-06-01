@extends('layouts.admin-layout')

@section('title', 'Modifier la Salle')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-ghost mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Modifier la Salle</h1>
        <p class="text-slate-500 mt-1">Éditer les informations de la salle : {{ $room->name }}</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="input-label">Nom de la salle</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $room->name) }}" required
                        class="input">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="input-label">Code unique</label>
                    <input type="text" id="code" name="code" value="{{ old('code', $room->code) }}" required
                        class="input">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="type" class="input-label">Type de salle</label>
                    <select id="type" name="type" required
                        class="input">
                        @foreach(\App\Models\Room::TYPES as $key => $label)
                            <option value="{{ $key }}" {{ old('type', $room->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="input-label">Capacité (places)</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" required min="1" max="500"
                        class="input">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $room->is_available) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Disponible</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="building" class="input-label">Bâtiment</label>
                    <input type="text" id="building" name="building" value="{{ old('building', $room->building) }}"
                        class="input">
                    @error('building')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="floor" class="input-label">Étage</label>
                    <input type="number" id="floor" name="floor" value="{{ old('floor', $room->floor) }}" required min="0" max="20"
                        class="input">
                    @error('floor')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn btn-primary">
                    Mettre à jour la salle
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-ghost">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
