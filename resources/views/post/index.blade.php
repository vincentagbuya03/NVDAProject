@extends('format.nav')

@section('title', 'Posts')

@section('content')
    @php
        $postCollection = $posts->getCollection();
    @endphp

    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">Post <span class="text-gradient">Management</span></h1>
            <p style="margin-bottom: 0;">Manage published content with the same card-and-table UI used across the other modules.</p>

            <div class="action-group" style="margin-top: 1rem;">
                <span class="badge badge-primary">Page Total: {{ $postCollection->count() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
            @if(in_array(auth()->user()->role, ['admin', 'teacher']))
            <div class="page-toolbar-start">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Post</a>
            </div>
            @else
            <div></div>
            @endif
            <div class="page-toolbar-end" style="flex: 1; max-width: 400px;">
                <input type="text" id="postSearch" class="field-input" placeholder="Search posts by title or content..." style="margin-bottom: 0;">
            </div>
        </div>

        <div class="card table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>#{{ $post->id }}</td>
                                <td style="font-weight: 600;">{{ $post->user->name ?? 'N/A' }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($post->content, 120) }}</td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        @if(in_array(auth()->user()->role, ['admin', 'teacher']))
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">Edit</a>
                                            <button type="button" class="btn btn-delete-post" data-url="{{ route('posts.destroy', $post->id) }}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
    
    @section('extra-js')
        <script src="{{ asset('js/table-utils.js') }}"></script>
        <script src="{{ asset('js/maintenance-table.js') }}"></script>
    @endsection
@endsection
