<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\Request;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $courses = Course::all();

    return view('courses.index', compact('courses'));
 }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('courses.create');
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:courses,code',
        'credit_hours' => 'required|integer|min:1|max:6',
    ]);

    Course::create($validated);

    return redirect()
        ->route('courses.index')
        ->with('success', 'Course created successfully.');
     }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
