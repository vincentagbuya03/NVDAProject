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
        Degree::updateOrCreate(['code' => 'BSIT'], [
            'name' => 'Bachelor of Science in Information Technology',
            'department' => 'Computer Science'
        ]);
        Degree::updateOrCreate(['code' => 'BSCS'], [
            'name' => 'Bachelor of Science in Computer Science',
            'department' => 'Computer Science'
        ]);
        Degree::updateOrCreate(['code' => 'BSED'], [
            'name' => 'Bachelor of Science in Education',
            'department' => 'Education'
        ]);
    }
}
