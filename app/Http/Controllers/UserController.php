<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
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
            'role' => ['required', 'string', 'in:user,admin,student,teacher'],
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'contact_no' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'degree_id' => ['required', 'integer', 'exists:degrees,id'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'user',
        ]);

        Log::info('User created', [
            'user_id' => $user->id,
            'email' => $user->email,
            'actor_id' => auth()->id(),
        ]);

        // Create student record with all required fields (now guaranteed by validation)
        Student::create([
            'user_id' => $user->id,
            'fname' => $validated['fname'],
            'mname' => $validated['mname'],
            'lname' => $validated['lname'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'contact_no' => $validated['contact_no'],
            'address' => $validated['address'],
            'degree_id' => $validated['degree_id'],
        ]);

        Log::info('Student record created for user', [
            'user_id' => $user->id,
            'student_name' => $validated['fname'] . ' ' . $validated['lname'],
        ]);

        // Create profile record for the user
        Profile::create([
            'user_id' => $user->id,
            'bio' => null,
            'image_url' => null,
            'status' => 'active',
        ]);

        Log::info('Profile record created for user', [
            'user_id' => $user->id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        Log::info('User edit opened', [
            'user_id' => $user->id,
            'actor_id' => auth()->id(),
        ]);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['nullable', 'string', 'in:user,admin,student'],
            'fname' => ['nullable', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'contact_no' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'degree_id' => ['nullable', 'integer', 'exists:degrees,id'],
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        if (!empty($validated['role'])) {
            $user->role = $validated['role'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update or create student record
        if (!empty($validated['fname']) || !empty($validated['lname'])) {
            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'fname' => $validated['fname'] ?? '',
                    'mname' => $validated['mname'] ?? '',
                    'lname' => $validated['lname'] ?? '',
                    'age' => $validated['age'],
                    'gender' => $validated['gender'],
                    'contact_no' => $validated['contact_no'],
                    'address' => $validated['address'],
                    'degree_id' => $validated['degree_id'],
                ]
            );
        }

        Log::info('User updated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'actor_id' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\Illuminate\Http\Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $deletedUserId = $user->id;
        $deletedEmail = $user->email;

        $user->delete();

        Log::info('User deleted', [
            'user_id' => $deletedUserId,
            'email' => $deletedEmail,
            'actor_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
