@extends('format.nav')

@section('title', 'Teacher Management')

@section('content')
    <div class="section-stack" id="teacherIndexSection" data-url="{{ route('teacher.index') }}">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">Teacher <span class="text-gradient">Management</span></h1>
            <p style="margin-bottom: 0;">Manage faculty accounts and their associated login credentials.</p>

            <div class="action-group" style="margin-top: 1rem;">
                <span class="badge badge-primary" id="totalTeachersBadge">Total Teachers: {{ $teachers->total() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
            <div class="page-toolbar-start">
                <button type="button" class="btn btn-primary" id="btnOpenCreateTeacher" data-url="{{ route('teacher.create') }}">Add New Teacher</button>
                <a href="{{ route('teacher.export') }}" class="btn btn-secondary">Export Excel</a>
                <a href="{{ route('teacher.export.pdf') }}" class="btn btn-secondary">Export PDF</a>
            </div>
            <div class="page-toolbar-end" style="flex: 1; max-width: 400px;">
                <input type="text" id="teacherSearch" class="field-input" placeholder="Search teachers by name or email..." style="margin-bottom: 0;">
            </div>
        </div>

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course/Dept</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teacherTableBody">
                        <tr>
                            <td colspan="6" class="empty-state">Loading teacher records...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" id="teacherPagination">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{ asset('js/forms.js') }}"></script>
    <script src="{{ asset('js/table-utils.js') }}"></script>
    <script src="{{ asset('js/teacher-table.js') }}"></script>
@endsection
