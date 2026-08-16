<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'name' => 'BS Computer Science'
        ]);

        Course::create([
            'name' => 'BS Software Engineering'
        ]);

        Course::create([
            'name' => 'BS Information Technology'
        ]);
    }
}