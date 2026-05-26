<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TeachersExport;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Profile;
use App\Models\Course;
use App\Models\Degree;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:teachers,email'],
            'password' => ['required', 'string', 'min:8'],
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'contact_no' => ['required', 'string', 'max:20'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'address' => ['required', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $user = null;
        $teacher = null;

        DB::transaction(function () use ($request, $validated, &$user, &$teacher) {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teacher',
                'is_active' => true,
                'force_password_change' => true,
            ]);

            Log::info('Teacher user account created', [
                'user_id' => $user->id,
                'email' => $user->email,
                'actor_id' => Auth::id(),
            ]);

            $teacher = Teacher::create([
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

            $profileImageUrl = null;
            if ($request->hasFile('profile_image')) {
                $profileImageUrl = $this->storeTeacherProfileImage($request->file('profile_image'), $user->id);
            }

            Profile::create([
                'user_id' => $user->id,
                'bio' => null,
                'image_url' => $profileImageUrl,
                'status' => 'active',
            ]);
        });

        if (!$user instanceof User) {
            Log::error('Teacher user creation failed (user is null after transaction).', [
                'email' => $validated['email'] ?? null,
                'actor_id' => Auth::id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to create teacher account. Please try again.',
                ], 500);
            }

            return redirect()->back()->withErrors([
                'error' => 'Unable to create teacher account. Please try again.',
            ])->withInput();
        }

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
        $teacher = Teacher::with(['user.profile', 'degree'])->findOrFail($id);
        return view('teacher.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::with('user.profile')->findOrFail($id);
        $degrees = Degree::all();
        return view('teacher.edit', compact('teacher', 'degrees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::with('user.profile')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('users', 'username')->ignore($teacher->user_id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($teacher->user_id),
                Rule::unique('teachers', 'email')->ignore($teacher->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'contact_no' => ['required', 'string', 'max:20'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'address' => ['required', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        DB::transaction(function () use ($request, $teacher, $validated) {
            $user = $teacher->user;

            if (! $user) {
                $user = User::create([
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'] ?: Str::random(12)),
                    'role' => 'teacher',
                    'is_active' => true,
                    'force_password_change' => true,
                ]);

                $teacher->user_id = $user->id;
            } else {
                $user->username = $validated['username'];
                $user->email = $validated['email'];
                $user->role = 'teacher';
                $user->is_active = true;

                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                    $user->force_password_change = true;
                }

                $user->save();
            }

            $teacher->fill([
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
            $teacher->save();

            if ($request->hasFile('profile_image')) {
                $profileImageUrl = $this->storeTeacherProfileImage($request->file('profile_image'), $teacher->user_id);
                Profile::updateOrCreate(
                    ['user_id' => $teacher->user_id],
                    ['image_url' => $profileImageUrl, 'status' => 'active']
                );
            } elseif (! $user->profile) {
                Profile::updateOrCreate(
                    ['user_id' => $teacher->user_id],
                    ['bio' => null, 'image_url' => null, 'status' => 'active']
                );
            }
        });

        Log::info('Teacher updated', [
            'teacher_id' => $teacher->id,
            'user_id' => $teacher->user_id,
            'actor_id' => Auth::id(),
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
        $user = Auth::user();
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
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        
        $course = Course::with(['students.user'])
            ->where('id', $courseId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $enrollments = \App\Models\Course_Student::where('course_id', $course->id)->get()->keyBy('student_id');

        return view('teacher.course_students', compact('course', 'teacher', 'enrollments'));
    }

    /**
     * Handle bulk grade submission for a course.
     */
    public function submitGrades(Request $request, string $courseId)
    {
        $user = Auth::user();
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

    public function export()
    {
        return Excel::download(new TeachersExport(), 'teachers.xlsx');
    }

    public function exportPdf()
    {
        $teachers = Teacher::with(['degree'])->orderBy('id')->get();

        return Pdf::loadView('exports.teachers_pdf', compact('teachers'))
            ->download('teachers.pdf');
    }

    private function storeTeacherProfileImage($uploadedFile, int $userId): string
    {
        $filename = 'teacher_' . $userId . '_' . Str::uuid() . '.jpg';
        $relativePath = 'teacher-profiles/' . $filename;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($uploadedFile->getPathname())
            ->cover(400, 400);

        Storage::disk('public')->put($relativePath, (string) $image->toJpeg(85));

        return ltrim(Storage::disk('public')->url($relativePath), '/');
    }
}
