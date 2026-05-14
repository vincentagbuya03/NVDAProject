@extends('format.nav')

@section('title', 'Course Student Details')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Assignment <span class="text-gradient">Details</span></h1>
            <p style="margin-bottom: 0;">Review the selected course-to-student link in the same detail-card layout as the other modules.</p>
        </div>

        <div class="detail-grid">
            <div class="card detail-card">
                <span class="detail-label">Assignment ID</span>
                <p class="detail-value">#{{ $courseStudent->id }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Student</span>
                <p class="detail-value">{{ $courseStudent->student->fname ?? '' }} {{ $courseStudent->student->lname ?? '' }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Course</span>
                <p class="detail-value">{{ $courseStudent->course->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card form-card">
            <div class="action-group">
                <a href="{{ route('course_students.edit', $courseStudent->id) }}" class="btn btn-primary">Edit Assignment</a>
                <a href="{{ route('course_students.index') }}" class="btn btn-secondary">Back to Assignments</a>
            </div>
        </div>
    </div>
@endsection
