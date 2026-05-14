<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Profile;
use App\Models\Course;
use App\Models\Degree;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Teacher::with(['user', 'degree'])->latest();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $teachers = $query->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'teachers' => $teachers,
                'total' => $teachers->total()
            ]);
        }

        return view('teacher.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $degrees = Degree::all();
        return view('teacher.create', compact('degrees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'contact_no' => ['required', 'string', 'max:20'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        // Create user account with teacher role
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'force_password_change' => true,
        ]);

        Log::info('Teacher user account created', [
            'user_id' => $user->id,
            'email' => $user->email,
            'actor_id' => auth()->id(),
        ]);

        // Create teacher record linked to user
        Teacher::create([
            'user_id' => $user->id,
            'fname' => $validated['fname'],
            'mname' => $validated['mname'] ?? '',
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'birthdate' => $validated['birthdate'],
            'gender' => $validated['gender'],
            'contact_no' => $validated['contact_no'],
            'degree_id' => $validated['degree_id'],
            'address' => $validated['address'],
        ]);

        // Create profile record for the teacher
        Profile::create([
            'user_id' => $user->id,
            'bio' => null,
            'image_url' => null,
            'status' => 'active',
        ]);

        Log::info('Teacher record created', [
            'user_id' => $user->id,
            'teacher_name' => $validated['fname'] . ' ' . $validated['lname'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Teacher account created successfully.',
                'redirect' => route('teacher.index')
            ]);
        }

        return redirect()->route('teacher.index')->with('success', 'Teacher account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('teacher.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $degrees = Degree::all();
        return view('teacher.edit', compact('teacher', 'degrees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username,' . $teacher->user_id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $teacher->user_id],
            'password' => ['nullable', 'string', 'min:8'],
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'contact_no' => ['required', 'string', 'max:20'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        // Update user account
        if ($teacher->user) {
            $teacher->user->username = $validated['username'];
            $teacher->user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $teacher->user->password = Hash::make($validated['password']);
            }

            $teacher->user->save();
        }

        // Update teacher record
        $teacher->update([
            'fname' => $validated['fname'],
            'mname' => $validated['mname'] ?? '',
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'birthdate' => $validated['birthdate'],
            'gender' => $validated['gender'],
            'contact_no' => $validated['contact_no'],
            'degree_id' => $validated['degree_id'],
            'address' => $validated['address'],
        ]);

        Log::info('Teacher updated', [
            'teacher_id' => $teacher->id,
            'user_id' => $teacher->user_id,
            'actor_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Teacher updated successfully.',
                'redirect' => route('teacher.index')
            ]);
        }

        return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $teacherName = $teacher->fname . ' ' . $teacher->lname;

        // Delete the user (cascades to teacher via foreign key)
        if ($teacher->user) {
            $teacher->user->delete();
        } else {
            $teacher->delete();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Teacher deleted successfully.'
            ]);
        }

        return redirect()->route('teacher.index')->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Display the teacher dashboard for logged-in teachers.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $teacher = Teacher::with(['courses.students'])->where('user_id', $user->id)->firstOrFail();

        // Calculate total unique students across all their courses
        $totalStudents = $teacher->courses->flatMap->students->unique('id')->count();
        $totalClasses = $teacher->courses->count();

        return view('teacher.dashboard', compact('teacher', 'user', 'totalStudents', 'totalClasses'));
    }

    /**
     * Display students for a specific course assigned to the teacher.
     */
    public function courseStudents(string $courseId)
    {
        $user = auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        
        $course = Course::with(['students.user'])
            ->where('id', $courseId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        // Get enrollment data (grades/status) for these students
        $enrollments = \App\Models\Course_Student::where('course_id', $course->id)->get()->keyBy('student_id');

        return view('teacher.course_students', compact('course', 'teacher', 'enrollments'));
    }

    /**
     * Handle bulk grade submission for a course.
     */
    public function submitGrades(Request $request, string $courseId)
    {
        $user = auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        
        // Security check
        $course = Course::where('id', $courseId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $grades = $request->input('grades', []);
        $statuses = $request->input('statuses', []);

        foreach ($grades as $studentId => $grade) {
            \App\Models\Course_Student::where('course_id', $courseId)
                ->where('student_id', $studentId)
                ->update([
                    'grade' => $grade,
                    'status' => $statuses[$studentId] ?? 'enrolled'
                ]);
        }

        return redirect()->back()->with('success', 'Grades and statuses updated successfully.');
    }
}
