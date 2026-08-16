<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('course');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($courseQuery) use ($search) {

                        $courseQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                    });

            });
        }

        $students = $query->latest()->paginate(5);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();

        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        Student::create($validated);

        return redirect('/students');
    }

    public function edit(Student $student)
    {
        $courses = Course::all();

        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $student->update($validated);

        return redirect('/students');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect('/students');
    }
}