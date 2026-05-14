@extends('format.nav')

@section('title', 'Teacher Details')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">Teacher <span class="text-gradient">Profile</span></h1>
            <p style="margin-bottom: 0;">Detailed view of faculty member and system account status.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            <!-- Sidebar: Identity Card -->
            <div class="card" style="padding: 2rem; height: fit-content; text-align: center;">
                <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white; font-weight: 700; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    {{ substr($teacher->fname, 0, 1) }}{{ substr($teacher->lname, 0, 1) }}
                </div>
                <h2 style="margin: 0;">{{ $teacher->fname }} {{ $teacher->lname }}</h2>
                <p style="color: #666; margin-bottom: 1.5rem;">{{ $teacher->degree->name ?? 'No Degree' }} Department</p>
                
                <div class="badge badge-success" style="padding: 0.5rem 1rem; width: 100%;">Active Faculty</div>
                
                <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-primary" style="width: 100%;">Edit Profile</a>
                    <a href="{{ route('teacher.index') }}" class="btn btn-secondary" style="width: 100%;">Back to List</a>
                </div>
            </div>

            <!-- Main Content: Details -->
            <div class="section-stack">
                <div class="card" style="padding: 2rem;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">Information Details</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Full Name</p>
                            <p style="font-weight: 600;">{{ $teacher->fname }} {{ $teacher->mname }} {{ $teacher->lname }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Birthdate / Gender</p>
                            <p style="font-weight: 600;">{{ \Carbon\Carbon::parse($teacher->birthdate)->format('M d, Y') }}, {{ $teacher->gender }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Contact Number</p>
                            <p style="font-weight: 600;">{{ $teacher->contact_no }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Email Address</p>
                            <p style="font-weight: 600;">{{ $teacher->email }}</p>
                        </div>
                        <div style="grid-column: span 2;">
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Home Address</p>
                            <p style="font-weight: 600;">{{ $teacher->address }}</p>
                        </div>
                    </div>
                </div>

                <div class="card" style="padding: 2rem;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">System Account</h3>
                    
                    <div style="display: flex; gap: 2rem;">
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Username</p>
                            <p style="font-weight: 700; font-family: monospace; font-size: 1.1rem;">{{ $teacher->user->username ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">System Role</p>
                            <p><span class="badge badge-primary">TEACHER</span></p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #666; text-transform: uppercase; margin-bottom: 0.25rem;">Account Created</p>
                            <p style="font-weight: 600;">{{ $teacher->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
