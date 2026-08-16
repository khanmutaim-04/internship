<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Course;
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

    return view(
        'students.index',
        compact('students')
    );
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
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('profile_image')) {
        $validated['profile_image'] =
            $request->file('profile_image')->store('student-profiles', 'public');
    }

    Student::create($validated);

    return redirect()
        ->route('students.index')
        ->with('success', 'Student added successfully.');
}


    public function edit(Student $student)
{
    $courses = Course::all();

    return view('students.edit', compact('student', 'courses'));
}


    public function update(Request $request, Student $student)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email,' . $student->id,
        'course_id' => 'required|exists:courses,id',
        'semester' => 'required|integer|min:1|max:8',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('profile_image')) {

        $validated['profile_image'] =
            $request->file('profile_image')->store('student-profiles', 'public');
    }

    $student->update($validated);

    return redirect()
        ->route('students.index')
        ->with('success', 'Student updated successfully.');
}


    public function destroy(Student $student)
    {
        $student->delete();

        return redirect('/students');
    }
}