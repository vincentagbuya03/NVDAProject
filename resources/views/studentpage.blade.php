@extends('format.nav')

@section('title', 'Students')

@section('content')
    @php
        $studentCollection = $students->getCollection();
        $maleCount = $studentCollection->where('gender', 'Boy')->count();
        $femaleCount = $studentCollection->where('gender', 'Girl')->count();
    @endphp

    <div class="section-stack" id="studentIndexSection" data-url="{{ route('students.index') }}">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="width: 64px; height: 64px; border-radius: 1rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.7rem; box-shadow: var(--shadow-lg);">
                    ST
                </div>
                <div>
                    <h1 style="margin-bottom: 0.35rem;">Student <span class="text-gradient">Directory</span></h1>
                    <p style="margin-bottom: 0;">Track student records, degree assignments, and quick actions from one screen.</p>
                </div>
            </div>

            <div class="action-group" id="studentStatsGroup">
                <span class="badge badge-primary" id="totalStudentsBadge">Total Students: {{ $students->total() }}</span>
                <span class="badge" style="background: #ecfdf5; color: #16a34a;" id="boysBadge">Boys: {{ $maleCount }}</span>
                <span class="badge" style="background: #fdf2f8; color: #db2777;" id="girlsBadge">Girls: {{ $femaleCount }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
            <div class="page-toolbar-start">
                <button type="button" class="btn btn-primary" id="btnOpenCreateStudent" data-url="{{ route('students.create') }}">Add Student</button>
                <a href="{{ route('students.export') }}" class="btn btn-secondary">Export Excel</a>
                <a href="{{ route('students.export.pdf') }}" class="btn btn-secondary">Export PDF</a>
            </div>
            <div class="page-toolbar-end" style="flex: 1; max-width: 400px;">
                <input type="text" id="studentSearch" class="field-input" placeholder="Search students by name, email or course..." style="margin-bottom: 0;">
            </div>
        </div>

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Birthdate</th>
                            <th>Gender</th>
                            <th>Contact</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <tr>
                            <td colspan="9" class="empty-state">Loading student records...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" id="studentPagination">
                {{ $students->links() }}
            </div>
        </div>
    </div>
    
    @section('extra-js')
        <script src="{{ asset('js/table-utils.js') }}"></script>
        <script src="{{ asset('js/student-table.js') }}"></script>
    @endsection
@endsection
