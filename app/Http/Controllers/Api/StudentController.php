<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Get all students
     */
    public function index()
    {
        $students = Student::with('course')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Students fetched successfully',
            'data' => $students
        ], 200);
    }


    /**
     * Store a new student
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $student = Student::create($validated);

        $student->load('course');

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }


    /**
     * Get single student
     */
    public function show(Student $student)
    {
        $student->load('course');

        return response()->json([
            'success' => true,
            'message' => 'Student fetched successfully',
            'data' => $student
        ], 200);
    }


    /**
     * Update student
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $student->update($validated);

        $student->load('course');

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }


    /**
     * Delete student
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}