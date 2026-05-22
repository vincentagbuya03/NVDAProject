<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::with('degree')->latest();

        // If teacher, only show their courses
        if (Auth::check() && Auth::user()?->role === 'teacher') {
            $teacher = \App\Models\Teacher::where('user_id', Auth::id())->first();
            if ($teacher) {
                $query->where('teacher_id', $teacher->id);
            }
        }

        // Add search support for courses
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'courses' => $courses,
                'total' => $courses->total()
            ]);
        }

        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $teachers = \App\Models\Teacher::all();
        $degrees = \App\Models\Degree::all();
        return view('course.create', compact('teachers', 'degrees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'degree_id' => ['nullable', 'exists:degrees,id'],
        ]);

        $course = Course::create($validated);

        Log::info('Course created', [
            'course_id' => $course->id,
            'name' => $course->name,
            'teacher_id' => $course->teacher_id,
            'actor_id' => Auth::id(),
        ]);

        $response = [
            'success' => true,
            'message' => 'Course created successfully.',
            'redirect' => route('courses.index'),
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with(['teacher', 'students'])->findOrFail($id);
        return view('course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $course = Course::findOrFail($id);
        $teachers = \App\Models\Teacher::all();
        $degrees = \App\Models\Degree::all();

        Log::info('Course edit opened', [
            'course_id' => $course->id,
            'actor_id' => Auth::id(),
        ]);
        return view('course.edit', compact('course', 'teachers', 'degrees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'degree_id' => ['nullable', 'exists:degrees,id'],
        ]);

        $course = Course::findOrFail($id);
        $course->update($validated);

        Log::info('Course updated', [
            'course_id' => $course->id,
            'teacher_id' => $course->teacher_id,
            'actor_id' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully.',
                'redirect' => route('courses.index'),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $course = Course::findOrFail($id);
        $deletedCourseId = $course->id;

        $course->delete();

        Log::info('Course deleted', [
            'course_id' => $deletedCourseId,
            'actor_id' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully.'
            ]);
        }
    }
}
