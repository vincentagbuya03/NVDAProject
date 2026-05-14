@extends('format.nav')

@section('title', 'Student Details')

@section('content')
    @php
        $studentName = trim($student->fname . ' ' . $student->mname . ' ' . $student->lname);
        $age = \Carbon\Carbon::parse($student->birthdate)->age;
        $studentStatus = match (true) {
            $age == 19 => 'Freshman Student',
            $age == 20 => 'Sophomore Student',
            $age == 21 => 'Junior Student',
            $age == 22 => 'Senior Student',
            default => 'Irregular Student',
        };
    @endphp

    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Student <span class="text-gradient">Details</span></h1>
            <p style="margin-bottom: 0;">A complete student summary presented in the same modern card style as profile details.</p>
        </div>

        <div class="detail-grid">
            <div class="card detail-card">
                <span class="detail-label">Full Name</span>
                <p class="detail-value">{{ $studentName }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Email</span>
                <p class="detail-value">{{ $student->user->email ?? 'N/A' }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Birthdate</span>
                <p class="detail-value">{{ \Carbon\Carbon::parse($student->birthdate)->format('M d, Y') }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Gender</span>
                <p class="detail-value">{{ $student->gender }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Contact Number</span>
                <p class="detail-value">{{ $student->contact_no }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Course</span>
                <p class="detail-value">{{ $student->degree->name ?? 'N/A' }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Address</span>
                <p class="detail-value">{{ $student->address }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Status</span>
                <p class="detail-value">{{ $studentStatus }}</p>
            </div>
        </div>

        <div class="card form-card">
            <div class="action-group">
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit Student</a>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: #ef4444; color: white;" onclick="return confirm('Are you sure?');">Delete</button>
                </form>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to Students</a>
            </div>
        </div>
    </div>
@endsection
