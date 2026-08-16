<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

Route::apiResource('students', StudentController::class);
Route::get('/students', function () {
    $students = Student::with('course')->get();

    return response()->json([
        'success' => true,
        'message' => 'Students fetched successfully',
        'data'    => $students
    ], 200);
});