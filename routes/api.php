<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\MonthlyGoalController;
use Illuminate\Support\Facades\Route;

// 🟢 Auth public (login)
Route::post('/login', [AuthController::class, 'login']);

// 🔐 Authentifié
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated user
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Resources
    Route::apiResource('/activities', ActivityController::class);
    Route::apiResource('/activity-types', ActivityTypeController::class);
    Route::apiResource('monthly-goals', MonthlyGoalController::class);
    Route::apiResource('/logs', LogController::class);
    Route::get('/summary', [MonthlyGoalController::class, 'summary']);

});
