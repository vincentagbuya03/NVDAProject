@extends('format.nav')

@section('title', 'Course Details')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Course <span class="text-gradient">Details</span></h1>
            <p style="margin-bottom: 0;">Review the selected course using the same detail card presentation as profile and student pages.</p>
        </div>

        <div class="detail-grid">
            <div class="card detail-card">
                <span class="detail-label">Course ID</span>
                <p class="detail-value">{{ $course->id }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Course Name</span>
                <p class="detail-value">{{ $course->name }}</p>

            </div>
            <div class="card detail-card" style="grid-column: 1 / -1;">
                <span class="detail-label">Assigned Instructor</span>
                <p class="detail-value">
                    @if($course->teacher)
                        <span class="badge badge-primary">Prof. {{ $course->teacher->fname }} {{ $course->teacher->lname }}</span>
                    @else
                        <span class="text-muted">No instructor assigned</span>
                    @endif
                </p>
            </div>
            <div class="card detail-card" style="grid-column: 1 / -1;">
                <span class="detail-label">Description</span>
                <p class="detail-value">{{ $course->description }}</p>
            </div>
        </div>

        <div class="card table-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0;">Enrolled <span class="text-gradient">Students</span></h3>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->students as $student)
                            <tr>
                                <td>#{{ $student->id }}</td>
                                <td style="font-weight: 600;">{{ $student->fname }} {{ $student->lname }}</td>
                                <td>{{ $student->user->email ?? 'N/A' }}</td>
                                <td><span class="badge badge-secondary">Enrolled</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No students enrolled yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card form-card">
            <div class="action-group">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">Edit Course</a>
                @endif
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to Courses</a>
            </div>
        </div>
    </div>
@endsection
