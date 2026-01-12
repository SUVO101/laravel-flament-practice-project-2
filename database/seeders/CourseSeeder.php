<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            "title"=> "PHP",
            "description"=> "PHP is a server scripting language and a powerful tool for making dynamic and interactive websites.",
            "duration"=> "2 months",
        ]);
        Course::create([
            "title"=> "Laravel",
            "description"=> "Laravel is a web application framework with a focus on developer experience and a fast development cycle.",
            "duration"=> "3 months",
        ]);
        Course::create([
            "title"=> "Python",
            "description"=> "Python is a high-level, general-purpose programming language.",
            "duration"=> "4 months",
        ]);
    }
}
