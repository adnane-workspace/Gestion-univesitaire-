@extends('layouts.admin-layout')

@section('title', 'Modifier Étudiant')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="btn btn-ghost mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Modifier l'Étudiant</h1>
        <p class="text-slate-500 mt-1">{{ $student->first_name }} {{ $student->last_name }}</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="input-label">Prénom</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required
                        class="input">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="input-label">Nom</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required
                        class="input">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="input-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required
                        class="input">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="input-label">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $student->phone) }}"
                        class="input">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="address" class="input-label">Adresse</label>
                <textarea id="address" name="address" rows="3"
                    class="input">{{ old('address', $student->address) }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn btn-primary">
                    Mettre à jour
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-ghost">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
