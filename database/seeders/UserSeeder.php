<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Degree;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        Profile::updateOrCreate(['user_id' => $admin->id], ['status' => 'active']);

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ]
        );
        Profile::updateOrCreate(['user_id' => $user->id], ['status' => 'active']);

        $studentUser = User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'username' => 'student',
                'email' => 'student@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'is_active' => true,
            ]
        );
        Profile::updateOrCreate(['user_id' => $studentUser->id], ['status' => 'active']);

        $degree = Degree::firstOrCreate(
            ['code' => 'BSIT'],
            [
                'name' => 'Bachelor of Science in Information Technology',
                'department' => 'Computer Science',
            ]
        );

        Student::updateOrCreate(
            ['user_id' => $studentUser->id],
            [
                'fname' => 'Jane',
                'mname' => 'Marie',
                'lname' => 'Smith',
                'email' => $studentUser->email,
                'contact_no' => '09123456789',
                'age' => 20,
                'gender' => 'Female',
                'degree_id' => $degree->id,
                'address' => 'Sample Address',
            ]
        );
    }
}

