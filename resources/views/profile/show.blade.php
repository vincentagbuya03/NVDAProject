@extends('format.nav')

@section('title', 'Profile Details')

@section('content')
    @php
        $displayName = $profile->user->name ?? 'N/A';
        $displayEmail = $profile->user->email ?? 'N/A';
        $displayBio = $profile->bio ?? 'No bio yet.';
        $displayImage = $profile->image_url;
        $displayStatus = $profile->status ?? 'inactive';
    @endphp

    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <div style="display: flex; align-items: center; gap: 1.75rem; margin-bottom: 2rem;">
            @if ($displayImage)
                <img src="{{ $displayImage }}" alt="Profile Photo" style="width: 80px; height: 80px; border-radius: 1.5rem; object-fit: cover; box-shadow: var(--shadow-lg);">
            @else
                <div style="width: 80px; height: 80px; background: var(--primary); color: white; border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: var(--shadow-lg);">
                    👤
                </div>
            @endif
            <div>
                <h1 style="margin-bottom: 0.4rem;">Profile <span class="text-gradient">Details</span></h1>
                <p style="margin-bottom: 0;">Single profile information with linked user account.</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 48px; height: 48px; background: rgba(99, 102, 241, 0.1); color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    🆔
                </div>
                <h3 style="margin: 0;">Account Info</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                    <small style="color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Full Name</small>
                    <p style="margin-top: 0.25rem; font-weight: 600;">{{ $displayName }}</p>
                </div>
                <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                    <small style="color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Email Address</small>
                    <p style="margin-top: 0.25rem; font-weight: 600;">{{ $displayEmail }}</p>
                </div>
                <div>
                    <small style="color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Bio</small>
                    <div style="margin-top: 0.5rem;">
                        <span class="badge badge-primary">{{ $displayBio }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 48px; height: 48px; background: rgba(14, 165, 233, 0.1); color: var(--secondary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    📌
                </div>
                <h3 style="margin: 0;">Profile Meta</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-weight: 600;">Profile ID</p>
                        <small style="color: var(--text-muted);">Database reference</small>
                    </div>
                    <span class="badge" style="background: #eef2ff; color: #6366f1;">#{{ $profile->id }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-weight: 600;">Image Link</p>
                        <small style="color: var(--text-muted);">Avatar source URL</small>
                    </div>
                    @if ($displayImage)
                        <span class="badge" style="background: #ecfdf5; color: #16a34a;">Available</span>
                    @else
                        <span class="badge" style="background: #fefce8; color: #ca8a04;">Missing</span>
                    @endif
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-weight: 600;">Profile Status</p>
                        <small style="color: var(--text-muted);">Current availability</small>
                    </div>
                    @if ($displayStatus === 'active')
                        <span class="badge" style="background: #ecfdf5; color: #16a34a;">Active</span>
                    @else
                        <span class="badge" style="background: #fefce8; color: #ca8a04;">Inactive</span>
                    @endif
                </div>
                <div>
                    <small style="color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Image URL</small>
                    <p style="margin-top: 0.35rem; font-weight: 600; color: var(--text-muted); overflow-wrap: anywhere;">{{ $displayImage ?? 'No image URL' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 1.5rem 2rem; margin-bottom: 3rem; display: flex; gap: 1rem; flex-wrap: wrap;">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Back to Profiles</a>
        @elseif(auth()->user()->role === 'teacher')
            <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        @else
            <a href="{{ route('clientDashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        @endif
        <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary">Edit Profile</a>
        <a href="{{ route('clientProfile') }}" class="btn btn-primary">Open Client Profile UI</a>
    </div>
@endsection
