@extends('format.nav')

@section('title', 'Manage Class: ' . $course->name)

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h1 style="margin-bottom: 0.4rem;">Manage <span class="text-gradient">Class</span></h1>
                    <p style="margin-bottom: 0;">{{ $course->name }} &mdash; Student List and Grading</p>
                </div>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card form-card">
            <form action="{{ route('teacher.course.grade', $course->id) }}" method="POST">
                @csrf
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Status</th>
                                <th style="width: 150px;">Grade</th>
                                <th style="width: 200px;">Outcome</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($course->students as $student)
                                @php
                                    $enrollment = $enrollments->get($student->id);
                                @endphp
                                <tr>
                                    <td>#{{ $student->id }}</td>
                                    <td>
                                        <div style="font-weight: 600;">{{ $student->fname }} {{ $student->lname }}</div>
                                        <div style="font-size: 0.75rem; color: #666;">{{ $student->user->email ?? 'No email' }}</div>
                                    </td>
                                    <td>
                                        <select name="statuses[{{ $student->id }}]" class="field-input" style="padding: 0.35rem; font-size: 0.875rem;">
                                            <option value="enrolled" {{ ($enrollment->status ?? '') === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                            <option value="completed" {{ ($enrollment->status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="dropped" {{ ($enrollment->status ?? '') === 'dropped' ? 'selected' : '' }}>Dropped</option>
                                            <option value="failed" {{ ($enrollment->status ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="grades[{{ $student->id }}]" value="{{ $enrollment->grade ?? '' }}" class="field-input" placeholder="e.g. 1.25" style="padding: 0.35rem;">
                                    </td>
                                    <td>
                                        @if(($enrollment->grade ?? '') !== '')
                                            <span class="badge {{ floatval($enrollment->grade) <= 3.0 ? 'badge-primary' : 'badge-danger' }}">
                                                {{ floatval($enrollment->grade) <= 3.0 ? 'Passing' : 'Failing' }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.75rem;">No grade yet</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">No students enrolled in this course.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($course->students->count() > 0)
                    <div class="action-group" style="margin-top: 2rem; padding: 1.5rem; border-top: 1px solid #e5e7eb; background: var(--bg-main); border-radius: 0 0 12px 12px;">
                        <button type="submit" class="btn btn-primary">Save All Changes</button>
                        <p style="margin: 0; font-size: 0.875rem; color: #666;">Changes will be saved for all students in the list.</p>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
