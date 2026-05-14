@extends('format.nav')

@section('title', 'Users')

@section('content')
    @php
        $userCollection = $users->getCollection();
    @endphp

    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">User <span class="text-gradient">Management</span></h1>
            <p style="margin-bottom: 0;">Manage platform accounts with the same clean directory layout used by profiles.</p>

            <div class="action-group" style="margin-top: 1rem;">
                <span class="badge badge-primary">Page Total: {{ $userCollection->count() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
            <div class="page-toolbar-start">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
            </div>
            <div class="page-toolbar-end" style="flex: 1; max-width: 400px;">
                <input type="text" id="userSearch" class="field-input" placeholder="Search users by username or email..." style="margin-bottom: 0;">
            </div>
        </div>

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td style="font-weight: 600;">{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">Edit</a>
                                        <button type="button" class="btn btn-delete-user" data-url="{{ route('users.destroy', $user->id) }}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    
    @section('extra-js')
        <script src="{{ asset('js/table-utils.js') }}"></script>
        <script src="{{ asset('js/maintenance-table.js') }}"></script>
    @endsection
@endsection
