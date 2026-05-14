<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PasswordChangeController extends Controller
{
    /**
     * Show the change password form
     */
    public function show()
    {
        return view("auth.change-password");
    }

    /**
     * Update the password
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            "old_password" => ["required", "string"],
            "new_password" => ["required", "string", "min:8", "confirmed"],
        ], [
            "new_password.confirmed" => "The confirm password does not match.",
        ]);

        $user = User::query()->findOrFail(Auth::id());

        // Verify old password
        if (!Hash::check($validated["old_password"], $user->password)) {
            return back()->withErrors(["old_password" => "The old password does not match."]);
        }

        // Check that new password is different from old password
        if (Hash::check($validated["new_password"], $user->password)) {
            return back()->withErrors(["new_password" => "The new password must be different from the old password."]);
        }

        $user->password = Hash::make($validated["new_password"]);
        $user->force_password_change = false;
        $user->save();

        Log::info("User password changed", [
            "user_id" => $user->id,
            "email" => $user->email,
        ]);

        return redirect()
            ->route("home")
            ->with("success", "Password changed successfully. You can now access the full system.");
    }
}
