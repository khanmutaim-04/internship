<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;

Route::get('/students', function () {
    $students = Student::with('course')->get();

    return response()->json([
        'success' => true,
        'message' => 'Students fetched successfully',
        'data'    => $students
    ], 200);
});