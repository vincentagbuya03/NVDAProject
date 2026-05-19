<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function displayGreetings() {
        $name = "Vincent";
        $address = "Turac SCCP";
        // return view('greetings', ['name' => $name]);
        return view('greetings', compact('name' , 'address'));
    }

    public function clientProfile() {
        return view('clientProfile');
    }

    public function clientDashboard() {
        $user = Auth::user();
        
        // Fetch student record
        $student = \App\Models\Student::where('user_id', $user->id)->first();
        
        $enrolledCourses = [];
        $latestPosts = \App\Models\Post::with('user')->latest()->take(3)->get();

        if ($student) {
            // Get enrolled courses with enrollment details (grades/status)
            $enrolledCourses = \App\Models\Course_Student::with('course.teacher')
                ->where('student_id', $student->id)
                ->get();
        }

        return view('clientDashboard', compact('user', 'student', 'enrolledCourses', 'latestPosts'));
    }

    public function clientAboutUs() {
        return view('clientAboutUs');
    }   








    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
