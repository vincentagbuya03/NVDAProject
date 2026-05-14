@extends('format.nav')

@section('title', 'Courses')

@section('content')
    @php
        $courseCollection = $courses->getCollection();
    @endphp

    <div class="section-stack" id="courseIndexSection" data-url="{{ route('courses.index') }}">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">Course <span class="text-gradient">Catalog</span></h1>
            <p style="margin-bottom: 0;">Organize course offerings with the same modern listing style used in the profile pages.</p>

            <div class="action-group" style="margin-top: 1rem;">
                <span class="badge badge-primary" id="totalCoursesBadge">Total Courses: {{ $courses->total() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(auth()->user()->role === 'admin')
        <div class="page-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
            <div class="page-toolbar-start">
                <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>
            </div>
            <div class="page-toolbar-end" style="flex: 1; max-width: 400px;">
                <input type="text" id="courseSearch" class="field-input" placeholder="Search courses by name or description..." style="margin-bottom: 0;">
            </div>
        </div>
        @endif

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Degree</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="courseTableBody">
                        @forelse ($courses as $course)
                            <tr>
                                <td>#{{ $course->id }}</td>
                                <td style="font-weight: 600;">{{ $course->name }}</td>
                                <td>{{ $course->description }}</td>
                                <td><span class="badge badge-secondary">{{ $course->degree->name ?? 'N/A' }}</span></td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">Edit</a>
                                            <button type="button" class="btn btn-delete-course" data-url="{{ route('courses.destroy', $course->id) }}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No courses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" id="coursePagination">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
    
    @section('extra-js')
        <script src="{{ asset('js/table-utils.js') }}"></script>
        <script src="{{ asset('js/course.js') }}"></script>
    @endsection
@endsection
