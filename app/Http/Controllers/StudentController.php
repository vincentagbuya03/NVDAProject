<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Models\Student;
use App\Models\Degree;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class StudentController extends Controller
{
    public function index(Request $request){
        $query = Student::with(['user', 'degree'])->latest();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('degree', function($dq) use ($search) {
                      $dq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $students = $query->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'students' => $students,
                'total' => $students->total(),
                'maleCount' => Student::where('gender', 'Boy')->count(),
                'femaleCount' => Student::where('gender', 'Girl')->count()
            ]);
        }

        return view("studentpage")->with("students", $students);
    }

    public function create(){
        $degrees = Degree::all();
        return view("student.create", compact("degrees"));
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|min:2|max:50',
            'mname' => 'nullable|string|min:1|max:50',
            'lname' => 'required|string|min:2|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|string|max:50',
            'contact_no' => 'required|string|max:11',
            'degree_id' => 'required|integer|exists:degrees,id',
            'email' => 'required|string|email|max:255|unique:users,email|unique:students,email',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tempPassword = $request->input('password') ?? Str::random(12);

        $user = null;
        $student = null;

        DB::transaction(function () use ($request, $tempPassword, &$user, &$student) {
            $user = User::create([
                'username' => $request->input('email'),
                'email' => $request->input('email'),
                'password' => Hash::make($tempPassword),
                'role' => 'student',
                'is_active' => true,
                'force_password_change' => true,
            ]);

            $student = Student::create([
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname') ?? '',
                'lname' => $request->input('lname'),
                'birthdate' => $request->input('birthdate'),
                'gender' => $request->input('gender'),
                'contact_no' => $request->input('contact_no'),
                'degree_id' => $request->input('degree_id'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'user_id' => $user->id,
            ]);
        });

        if (!$user instanceof User) {
            Log::error('Student user creation failed (user is null after transaction).', [
                'email' => $request->input('email'),
                'actor_id' => Auth::id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to create student account. Please try again.',
                ], 500);
            }

            return redirect()->back()->withErrors([
                'error' => 'Unable to create student account. Please try again.',
            ])->withInput();
        }

        $msg = "New student created: " . $request->input('fname') . " " . $request->input('lname');
        Log::info($msg, [
            'user_id' => $user->id,
            'temporary_password' => $tempPassword,
        ]);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Student created successfully. Temporary password: {$tempPassword}",
                'redirect' => route('students.index')
            ]);
        }
        return redirect()->route('students.index')->with('success', "Student created successfully. Temporary password: {$tempPassword}");
    }

    public function show(string $id){
        $student = Student::with(['user', 'degree'])->findOrFail($id);
        return view("student.show", compact("student"));
    }
    public function edit(string $id){
        $degrees = Degree::all();
        $student = Student::with('user')->findOrFail($id);
        Log::info('Student edit opened', [
            'student_id' => $id,
            'actor_id' => Auth::id(),
        ]);
        return view("student.edit", compact("student", "degrees"));
    }
    public function update(Request $request, string $id){

        Log::info('Updating student with ID: ' . $id);
        $student = Student::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'min:2', 'max:50'],
            'mname' => ['nullable', 'string', 'min:0', 'max:50'],
            'lname' => ['required', 'string', 'min:2', 'max:50'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:50'],
            'contact_no' => ['required', 'string', 'max:11'],
            'degree_id' => ['required', 'integer', 'exists:degrees,id'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],
            'address' => ['required', 'string', 'max:255'],
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

        DB::transaction(function () use ($student, $validated) {
            $user = $student->user;

            if (! $user) {
                $user = User::create([
                    'username' => $validated['email'],
                    'email' => $validated['email'],
                    'password' => Hash::make(Str::random(12)),
                    'role' => 'student',
                    'is_active' => true,
                    'force_password_change' => true,
                ]);

                $student->user_id = $user->id;
            } else {
                $user->username = $validated['email'];
                $user->email = $validated['email'];
                $user->role = 'student';
                $user->is_active = true;
                $user->save();
            }

            $student->fill([
                'fname' => $validated['fname'],
                'mname' => $validated['mname'] ?? '',
                'lname' => $validated['lname'],
                'contact_no' => $validated['contact_no'],
                'degree_id' => $validated['degree_id'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'gender' => $validated['gender'],
                'birthdate' => $validated['birthdate'],
            ]);
            $student->save();
        });

        Log::info('Student updated successfully: ' . $student->fname . ' ' . $student->lname);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully.',
                'redirect' => route('students.index')
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }
    public function destroy(Request $request, string $id){
        Log::info('Deleting student with ID: ' . $id);
        $student = Student::with('user')->findOrFail($id);

        DB::transaction(function () use ($student) {
            if ($student->user) {
                $student->user->delete();
                return;
            }

            $student->delete();
        });

        Log::info('Student deleted successfully: ' . $id);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully.'
            ]);
        }
        
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new StudentsExport(), 'students.xlsx');
    }

    public function exportPdf()
    {
        $students = Student::with(['degree'])->orderBy('id')->get();

        return Pdf::loadView('exports.students_pdf', compact('students'))
            ->download('students.pdf');
    }
}
