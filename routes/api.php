<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AuthController;

// Public Login API
Route::post('/login', [AuthController::class, 'login']);

// Protected Student APIs
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/students', [StudentController::class, 'index']);

    Route::post('/students', [StudentController::class, 'store']);

    Route::get('/students/{student}', [StudentController::class, 'show']);

    Route::put('/students/{student}', [StudentController::class, 'update']);

    Route::delete('/students/{student}', [StudentController::class, 'destroy']);

});