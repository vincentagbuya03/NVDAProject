<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        Log::info('Login attempt', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Login failed', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
            ]);

            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        Log::info('Login successful', [
            'user_id' => Auth::id(),
            'email' => $credentials['email'],
            'ip' => $request->ip(),
        ]);

        if (Auth::user()->force_password_change) {
            return redirect()->route('password.change');
        }

        // Redirect based on role
        $user = Auth::user();
        if ($user->role === 'teacher') {
            return redirect()
                ->route('teacher.dashboard')
                ->with('login_success', true)
                ->with('login_success_message', 'Welcome back, ' . $user->username . '! You are now logged in.');
        }

        if ($user->role === 'student') {
            return redirect()
                ->route('clientDashboard')
                ->with('login_success', true)
                ->with('login_success_message', 'Welcome back, ' . $user->username . '! You are now logged in.');
        }

        return redirect()
            ->intended(route('home'))
            ->with('login_success', true)
            ->with('login_success_message', 'Welcome back, ' . Auth::user()->username . '! You are now logged in.');
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            Log::info('User logout', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
