<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function hello()
    {
        $name = "Muhammad";
        $course = "BS Computer Science";
        $semester = 7;

        $skills = [
            "C++",
            "Python",
            "Flutter",
            "Laravel"
        ];

        return view('hello', compact(
            'name',
            'course',
            'semester',
            'skills'
        ));
    }
}