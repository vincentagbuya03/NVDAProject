<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Degree;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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

        // Generate temporary password if not provided
        $tempPassword = $request->input('password') ?? Str::random(12);
        
        // Create user account
        $user = User::create([
            'username' => $request->input('email'),
            'email' => $request->input('email'),
            'password' => Hash::make($tempPassword),
            'role' => 'student',
            'is_active' => true,
            'force_password_change' => true,
        ]);

        // Create student record
        $student = Student::create([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'birthdate' => $request->input('birthdate'),
            'gender' => $request->input('gender'),
            'contact_no' => $request->input('contact_no'),
            'degree_id' => $request->input('degree_id'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'user_id' => $user->id,
        ]);

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
        $student = Student::find($id);
        return view("student.show", compact("student"));
    }
    public function edit(string $id){
        $degrees = Degree::all();
        $student = Student::find($id);
        Log::info('Student edit opened', [
            'student_id' => $id,
            'actor_id' => Auth::id(),
        ]);
        return view("student.edit", compact("student", "degrees"));
    }
    public function update(Request $request, string $id){

        Log::info('Updating student with ID: ' . $id);
        // $validation = $request->validate([
        //     'fname' => ['required', 'string', 'min:2', 'max:50'],
        //     'mname' => ['required', 'string', 'min:2', 'max:50'],
        //     'lname' => ['required', 'string', 'min:2', 'max:50'],
        //     'age' => ['required', 'integer', 'min:1'],
        //     'gender' => ['required', 'string', 'max:50'],
        //     'contact_no' => ['required', 'string', 'max:9'],
        //     'degree_id' => ['required', 'integer', 'exists:degrees,id'],
        //     'email' => ['required', 'string', 'email', 'max:255'],
        //     'address' => ['required', 'string', 'max:255'],
        // ]);
        $validator = $request->validate([
            'fname' => ['required', 'string', 'min:2', 'max:50'],
            'mname' => ['nullable', 'string', 'min:0', 'max:50'],
            'lname' => ['required', 'string', 'min:2', 'max:50'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:50'],
            'contact_no' => ['required', 'string', 'max:11'],
            'degree_id' => ['required', 'integer', 'exists:degrees,id'],
            'email' => ['required', 'string', 'email', 'max:255' , 'unique:students,email,' . $id],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $student = Student::findOrFail($id);
        $student->fname = $request->input('fname');
        $student->mname = $request->input('mname');
        $student->lname = $request->input('lname');
        $student->contact_no = $request->input('contact_no');
        $student->degree_id = $request->input('degree_id');
        $student->email = $request->input('email');
        $student->address = $request->input('address');
        $student->gender = $request->input('gender');
        $student->birthdate = $request->input('birthdate');
        $student->save();
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
        Student::destroy($id);
        Log::info('Student deleted successfully: ' . $id);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully.'
            ]);
        }
        
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
