@extends('format.nav')

@section('title', 'Degrees')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="width: 64px; height: 64px; border-radius: 1rem; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: var(--shadow-lg);">
                    DG
                </div>
                <div>
                    <h1 style="margin-bottom: 0.35rem;">Degree <span class="text-gradient">Management</span></h1>
                    <p style="margin-bottom: 0;">Manage academic degrees and departments in one clean workspace.</p>
                </div>
            </div>

            <div class="action-group">
                <span class="badge badge-primary">Total: {{ $degrees->count() }}</span>
                <span class="badge" style="background: #ecfeff; color: #0891b2;">Departments: {{ $degrees->pluck('department')->filter()->unique()->count() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
            <div class="page-toolbar-start">
                <a href="{{ route('degrees.create') }}" class="btn btn-primary">Add Degree</a>
            </div>
            <div class="page-toolbar-end" style="flex: 1; max-width: 400px;">
                <input type="text" id="degreeSearch" class="field-input" placeholder="Search degrees by name, code or department..." style="margin-bottom: 0;">
            </div>
        </div>

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Degree Name</th>
                            <th>Code</th>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($degrees as $degree)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="font-weight: 600;">{{ $degree->name }}</td>
                                <td><span class="badge badge-primary">{{ $degree->code }}</span></td>
                                <td>{{ $degree->department }}</td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('degrees.edit', $degree->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">Edit</a>
                                        <button type="button" class="btn btn-delete-degree" data-url="{{ route('degrees.destroy', $degree->id) }}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No degrees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('extra-js')
        <script src="{{ asset('js/table-utils.js') }}"></script>
        <script src="{{ asset('js/maintenance-table.js') }}"></script>
    @endsection
@endsection
