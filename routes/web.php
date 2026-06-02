<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoomController;

use App\Http\Controllers\ProfesseurDashboardController;
use App\Http\Controllers\EtudiantDashboardController;
use App\Http\Controllers\ModuleQuestionController;
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
    
    // CRUD Étudiants
    Route::resource('students', StudentController::class);
    
    // CRUD Professeurs
    Route::resource('professors', ProfessorController::class);
    
    // CRUD Filières
    Route::resource('filieres', FiliereController::class);
    
    // CRUD Modules
    Route::resource('modules', ModuleController::class);
    
    // CRUD Salles
    Route::resource('rooms', RoomController::class);
    

});

// Routes Professeur (protégées par le middleware CheckProfesseur)
Route::middleware(['auth', 'CheckProfesseur'])->prefix('professeur')->name('professeur.')->group(function () {
    Route::get('/dashboard', [ProfesseurDashboardController::class, 'index'])->name('dashboard');
    Route::get('/modules', [ProfesseurDashboardController::class, 'modules'])->name('modules');
    Route::post('/modules/{module}/generate-qcm', [ModuleQuestionController::class, 'generate'])->name('modules.generate-qcm');
    Route::get('/modules/{module}/qcm', [ModuleQuestionController::class, 'show'])->name('modules.qcm');
    Route::get('/grades', [ProfesseurDashboardController::class, 'grades'])->name('grades');
    Route::post('/grades', [ProfesseurDashboardController::class, 'storeGrades'])->name('grades.store');
    Route::get('/absences', [ProfesseurDashboardController::class, 'absences'])->name('absences');
    Route::post('/absences', [ProfesseurDashboardController::class, 'storeAbsences'])->name('absences.store');
    Route::get('/schedule', [ProfesseurDashboardController::class, 'schedule'])->name('schedule');
});

// Routes Étudiant (protégées par le middleware CheckEtudiant)
Route::middleware(['auth', 'CheckEtudiant'])->prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/dashboard', [EtudiantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/grades', [EtudiantDashboardController::class, 'grades'])->name('grades');
    Route::get('/modules', [EtudiantDashboardController::class, 'modules'])->name('modules');
    Route::get('/schedule', [EtudiantDashboardController::class, 'schedule'])->name('schedule');
    Route::get('/bulletin', [EtudiantDashboardController::class, 'bulletinPdf'])->name('bulletin.pdf');
    Route::post('/chatbot/query', [EtudiantDashboardController::class, 'chatbotQuery'])->name('chatbot.query');
});
