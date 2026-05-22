@extends('format.nav')

@section('title', 'User Details')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">User <span class="text-gradient">Details</span></h1>
            <p style="margin-bottom: 0;">View account information in the same detail-card style as the profile module.</p>
        </div>

        <div class="detail-grid">
            <div class="card detail-card">
                <span class="detail-label">User ID</span>
                <p class="detail-value">#{{ $user->id }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Username</span>
                <p class="detail-value">{{ $user->username }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Email</span>
                <p class="detail-value">{{ $user->email }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Role</span>
                <p class="detail-value"><span class="badge" style="background: {{ $user->role === 'admin' ? '#3b82f6' : '#10b981' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 0.25rem;">{{ ucfirst($user->role) }}</span></p>
            </div>
        </div>

        @if($user->student)
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                <h2 style="margin-bottom: 1rem;">Student Information</h2>
                <div class="detail-grid">
                    <div class="card detail-card">
                        <span class="detail-label">Full Name</span>
                        <p class="detail-value">{{ $user->student->fname }} {{ $user->student->mname }} {{ $user->student->lname }}</p>
                    </div>
                    <div class="card detail-card">
                        <span class="detail-label">Birthdate</span>
                        <p class="detail-value">
                            {{ $user->student->birthdate ? \Carbon\Carbon::parse($user->student->birthdate)->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div class="card detail-card">
                        <span class="detail-label">Age</span>
                        <p class="detail-value">{{ $user->student->age ?? 'N/A' }}</p>
                    </div>
                    <div class="card detail-card">
                        <span class="detail-label">Gender</span>
                        <p class="detail-value">{{ $user->student->gender ?? 'N/A' }}</p>
                    </div>
                    <div class="card detail-card">
                        <span class="detail-label">Contact</span>
                        <p class="detail-value">{{ $user->student->contact_no ?? 'N/A' }}</p>
                    </div>
                    <div class="card detail-card">
                        <span class="detail-label">Address</span>
                        <p class="detail-value">{{ $user->student->address ?? 'N/A' }}</p>
                    </div>
                    <div class="card detail-card">
                        <span class="detail-label">Degree</span>
                        <p class="detail-value">{{ $user->student->degree->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="card form-card">
            <div class="action-group">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
            </div>
        </div>
    </div>
@endsection
