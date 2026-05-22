<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Course_Student;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CourseStudentController extends Controller
{
    public function index()
    {
        $courseStudents = Course_Student::with(['course', 'student'])->latest()->paginate(10);
        return view('course_student.index', compact('courseStudents'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        $students = Student::orderBy('fname')->get();
        return view('course_student.create', compact('courses', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'course_id' => ['required', 'exists:courses,id'],
                'student_id' => [
                    'required',
                    'exists:students,id',
                    Rule::unique('course_students')->where(function ($query) use ($request) {
                        return $query->where('course_id', $request->course_id);
                    }),
                ],
            ],
            [
                'student_id.unique' => 'This student already took this course.',
            ]
        );

        $assignment = Course_Student::create($validated);

        Log::info('Course student assignment created', [
            'assignment_id' => $assignment->id,
            'course_id' => $assignment->course_id,
            'student_id' => $assignment->student_id,
            'actor_id' => Auth::id(),
        ]);

        return redirect()->route('course_students.index')->with('success', 'Course student assignment created successfully.');
    }

    public function show(string $id)
    {
        $courseStudent = Course_Student::with(['course', 'student'])->findOrFail($id);
        return view('course_student.show', compact('courseStudent'));
    }

    public function edit(string $id)
    {
        $courseStudent = Course_Student::findOrFail($id);
        $courses = Course::orderBy('name')->get();
        $students = Student::orderBy('fname')->get();

        Log::info('Course student assignment edit opened', [
            'assignment_id' => $courseStudent->id,
            'actor_id' => Auth::id(),
        ]);

        return view('course_student.edit', compact('courseStudent', 'courses', 'students'));
    }

    public function update(Request $request, string $id)
    {
        $courseStudent = Course_Student::findOrFail($id);

        $validated = $request->validate(
            [
                'course_id' => ['required', 'exists:courses,id'],
                'student_id' => [
                    'required',
                    'exists:students,id',
                    Rule::unique('course_students')
                        ->where(function ($query) use ($request) {
                            return $query->where('course_id', $request->course_id);
                        })
                        ->ignore($courseStudent->id),
                ],
            ],
            [
                'student_id.unique' => 'This student already took this course.',
            ]
        );

        $courseStudent->update($validated);

        Log::info('Course student assignment updated', [
            'assignment_id' => $courseStudent->id,
            'course_id' => $courseStudent->course_id,
            'student_id' => $courseStudent->student_id,
            'actor_id' => Auth::id(),
        ]);

        return redirect()->route('course_students.index')->with('success', 'Course student assignment updated successfully.');
    }

    public function destroy(string $id)
    {
        $courseStudent = Course_Student::findOrFail($id);
        $deletedAssignmentId = $courseStudent->id;
        $deletedCourseId = $courseStudent->course_id;
        $deletedStudentId = $courseStudent->student_id;

        $courseStudent->delete();

        Log::info('Course student assignment deleted', [
            'assignment_id' => $deletedAssignmentId,
            'course_id' => $deletedCourseId,
            'student_id' => $deletedStudentId,
            'actor_id' => Auth::id(),
        ]);

        return redirect()->route('course_students.index')->with('success', 'Course student assignment deleted successfully.');
    }
}
