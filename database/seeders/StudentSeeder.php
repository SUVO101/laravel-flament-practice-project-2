<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            "name"=> "Ranit Nath",
            "email"=> "ranit@gmail.com",
            "phone"=> "1234567890",
            "address"=> "123 Main St",
        ]);
        Student::create([
            "name"=> "Pradipta Das",
            "email"=> "pradipta@gmail.com",
            "phone"=> "7845987451",
            "address"=> "Rathtala , Badamtala.",
        ]);
        Student::create([
            "name"=> "Subhankar Nath",
            "email"=> "subhankar@gmail.com",
            "phone"=> "8745963210",
            "address"=> "91 AB Road , Rathtala , Badamtala.",
        ]);
    }
}
