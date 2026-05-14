@extends('format.nav')

@section('title', 'Profile')

@section('content')
    @php
        $activeUser = $profile?->user ?? $fallbackUser ?? null;
        $displayName = $activeUser?->name ?? 'Guest User';
        $displayEmail = $activeUser?->email ?? 'No email available';
        $displayBio = $profile?->bio ?? 'No bio yet.';
        $displayImage = $profile?->image_url;
        $displayStatus = $profile?->status ?? 'inactive';
        $hasSavedProfile = (bool) $profile;
    @endphp

    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <div style="display: flex; align-items: center; gap: 2rem; margin-bottom: 2rem;">
            @if ($displayImage)
                <img src="{{ $displayImage }}" alt="Profile Photo" style="width: 80px; height: 80px; border-radius: 1.5rem; object-fit: cover; box-shadow: var(--shadow-lg);">
            @else
                <div style="width: 80px; height: 80px; background: var(--primary); color: white; border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; box-shadow: var(--shadow-lg);">
                    👤
                </div>
            @endif
            <div>
                <h1 style="margin-bottom: 0.5rem;">Welcome Back, <span class="text-gradient">{{ $displayName }}</span></h1>
                <p style="margin-bottom: 0;">Manage your account settings and preferences.</p>
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-bottom: 3rem;">
            @if ($profile)
                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary">Edit Profile</a>
            @else
                <button class="btn btn-primary" disabled title="No profile record available">Edit Profile</button>
            @endif
            <button class="btn btn-secondary">Settings</button>
            <button class="btn btn-secondary" style="border-color: var(--accent); color: var(--accent);">Sign Out</button>
        </div>

        @unless ($hasSavedProfile)
            <div class="alert alert-error" style="max-width: 760px; margin-bottom: 1rem;">
                No saved profile record was found in the `profiles` table, so this page is showing fallback user information only.
            </div>
        @endunless
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
        <!-- Profile Card -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 48px; height: 48px; background: rgba(99, 102, 241, 0.1); color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
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

        <!-- Stats Card -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 48px; height: 48px; background: rgba(14, 165, 233, 0.1); color: var(--secondary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    📈
                </div>
                <h3 style="margin: 0;">Activity Stats</h3>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div style="text-align: center; padding: 1.5rem; background: var(--bg-main); border-radius: 1rem;">
                    <h2 class="text-gradient" style="font-size: 2rem;">247</h2>
                    <small style="color: var(--text-muted); font-weight: 600;">Days Active</small>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: var(--bg-main); border-radius: 1rem;">
                    <h2 class="text-gradient" style="font-size: 2rem;">42</h2>
                    <small style="color: var(--text-muted); font-weight: 600;">Projects</small>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: var(--bg-main); border-radius: 1rem;">
                    <h2 class="text-gradient" style="font-size: 2rem;">8</h2>
                    <small style="color: var(--text-muted); font-weight: 600;">Badges</small>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: var(--bg-main); border-radius: 1rem;">
                    <h2 class="text-gradient" style="font-size: 2rem;">95%</h2>
                    <small style="color: var(--text-muted); font-weight: 600;">Score</small>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 48px; height: 48px; background: rgba(244, 63, 94, 0.1); color: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    🛡️
                </div>
                <h3 style="margin: 0;">Security</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-weight: 600;">Profile Status</p>
                        <small style="color: var(--text-muted);">Managed from profile edit form</small>
                    </div>
                    @if ($displayStatus === 'active')
                        <span class="badge" style="background-color: #ecfdf5; color: #10b981;">Active</span>
                    @else
                        <span class="badge" style="background-color: #fefce8; color: #eab308;">Inactive</span>
                    @endif
                </div>
                <button class="btn btn-secondary" style="margin-top: 1rem; width: 100%;">Change Password</button>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 4rem;">
        <h2 style="margin-bottom: 2rem;">Recent Activity</h2>
        <div class="card">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="font-size: 1.5rem;">🔐</div>
                    <div>
                        <p style="margin: 0; font-weight: 600;">Password Updated</p>
                        <small style="color: var(--text-muted);">Security settings modified successfully</small>
                    </div>
                </div>
                <small style="color: var(--text-muted); font-weight: 500;">2 hours ago</small>
            </div>
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="font-size: 1.5rem;">💻</div>
                    <div>
                        <p style="margin: 0; font-weight: 600;">New Device Login</p>
                        <small style="color: var(--text-muted);">Logged in from Chrome on Windows 11</small>
                    </div>
                </div>
                <small style="color: var(--text-muted); font-weight: 500;">5 hours ago</small>
            </div>
            <div style="padding: 1.5rem 2rem; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="font-size: 1.5rem;">📝</div>
                    <div>
                        <p style="margin: 0; font-weight: 600;">Profile Modified</p>
                        <small style="color: var(--text-muted);">Updated personal contact information</small>
                    </div>
                </div>
                <small style="color: var(--text-muted); font-weight: 500;">Yesterday</small>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
