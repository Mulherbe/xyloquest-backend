<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\MonthlyGoalController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskStatusController;
use App\Http\Controllers\Api\TaskItemController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaskCommentController;
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
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('task-status', TaskStatusController::class);
    Route::apiResource('task-items', TaskItemController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('task-comments', TaskCommentController::class);
    Route::get('/projects/{project}/tasks', [TaskController::class, 'byProject']);
    Route::get('tasks/{task}/task-comments', [TaskCommentController::class, 'index']);
    Route::post('tasks/{task}/link-activity', [TaskController::class, 'linkActivity']);

});
