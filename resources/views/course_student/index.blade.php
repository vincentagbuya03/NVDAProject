@extends('format.nav')

@section('title', 'Course Students')

@section('content')
    @php
        $assignmentCollection = $courseStudents->getCollection();
    @endphp

    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">Course <span class="text-gradient">Assignments</span></h1>
            <p style="margin-bottom: 0;">Review which students are linked to which courses in the same unified interface.</p>

            <div class="action-group" style="margin-top: 1rem;">
                <span class="badge badge-primary">Page Total: {{ $assignmentCollection->count() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-toolbar">
            <div class="page-toolbar-start">
                <a href="{{ route('course_students.create') }}" class="btn btn-primary">Add Assignment</a>
            </div>
        </div>

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courseStudents as $row)
                            <tr>
                                <td>#{{ $row->id }}</td>
                                <td style="font-weight: 600;">{{ $row->student->fname ?? '' }} {{ $row->student->lname ?? '' }}</td>
                                <td>{{ $row->course->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('course_students.show', $row->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        <a href="{{ route('course_students.edit', $row->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">Edit</a>
                                        <form action="{{ route('course_students.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;" onclick="return confirm('Delete this assignment?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No assignments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $courseStudents->links() }}
            </div>
        </div>
    </div>
@endsection
