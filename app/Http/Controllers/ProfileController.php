<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of profiles.
     */
    public function index()
    {
        $profiles = Profile::with('user')->latest()->paginate(10);
        $userCount = User::count();

        return view('profile.index', compact('profiles', 'userCount'));
    }

    /**
     * Display the specified profile.
     */
    public function show(string $id)
    {
        $profile = Profile::with('user')->findOrFail($id);

        return view('profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified profile.
     */
    public function edit(string $id)
    {
        $profile = Profile::with('user')->findOrFail($id);

        Log::info('Profile edit opened', [
            'profile_id' => $profile->id,
            'user_id' => $profile->user_id,
            'actor_id' => Auth::id(),
        ]);

        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified profile in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);

        $validated = $request->validate([
            'bio' => ['nullable', 'string', 'max:1000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $profile->update($validated);

        Log::info('Profile updated', [
            'profile_id' => $profile->id,
            'user_id' => $profile->user_id,
            'status' => $profile->status,
            'actor_id' => Auth::id(),
        ]);

        return redirect()->route('profiles.show', $profile->id)->with('success', 'Profile updated successfully.');
    }

    /**
     * Display a profile page used by the client UI.
     */
    public function clientProfile()
    {
        $profile = Profile::with('user')->where('user_id', Auth::id())->first();
        $fallbackUser = $profile ? null : Auth::user();

        return view('clientProfile', compact('profile', 'fallbackUser'));
    }
}
