<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Degree;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Degree::create([
            'name' => 'Bachelor of Science in Information Technology',
            'code' => 'BSIT',
            'department' => 'Computer Science'
        ]);
        Degree::create([
            'name' => 'Bachelor of Science in Computer Science',
            'code' => 'BSCS',
            'department' => 'Computer Science'
        ]);
        Degree::create([
            'name' => 'Bachelor of Science in Education',
            'code' => 'BSED',
            'department' => 'Education'
        ]);
    }
}
