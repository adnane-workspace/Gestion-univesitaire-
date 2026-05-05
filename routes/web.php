<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfesseurDashboardController;
use App\Http\Controllers\EtudiantDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Routes Admin (protégées par le middleware CheckAdmin)
Route::middleware(['auth', 'CheckAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Routes Professeur (protégées par le middleware CheckProfesseur)
Route::middleware(['auth', 'CheckProfesseur'])->prefix('professeur')->name('professeur.')->group(function () {
    Route::get('/dashboard', [ProfesseurDashboardController::class, 'index'])->name('dashboard');
});

// Routes Étudiant (protégées par le middleware CheckEtudiant)
Route::middleware(['auth', 'CheckEtudiant'])->prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/dashboard', [EtudiantDashboardController::class, 'index'])->name('dashboard');
});
