<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\RoomApiController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);

    // Student endpoints
    Route::get('student/grades', [StudentApiController::class, 'grades']);
    Route::get('student/gpa', [StudentApiController::class, 'gpa']);
    Route::get('student/schedule', [StudentApiController::class, 'schedule']);
    Route::get('student/absences', [StudentApiController::class, 'absences']);

    // Rooms
    Route::get('rooms/{id}/schedule', [RoomApiController::class, 'schedule']);
});
