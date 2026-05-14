@extends('format.nav')

@section('title', 'Post Details')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Post <span class="text-gradient">Details</span></h1>
            <p style="margin-bottom: 0;">Review the selected post using the same detail-card presentation as the other modules.</p>
        </div>

        <div class="detail-grid">
            <div class="card detail-card">
                <span class="detail-label">Post ID</span>
                <p class="detail-value">#{{ $post->id }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Author</span>
                <p class="detail-value">{{ $post->user->name ?? 'N/A' }}</p>
            </div>
            <div class="card detail-card">
                <span class="detail-label">Title</span>
                <p class="detail-value">{{ $post->title }}</p>
            </div>
            <div class="card detail-card" style="grid-column: 1 / -1;">
                <span class="detail-label">Content</span>
                <p class="detail-value">{{ $post->content }}</p>
            </div>
        </div>

        <div class="card form-card">
            <div class="action-group">
                @if(in_array(auth()->user()->role, ['admin', 'teacher']))
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit Post</a>
                @endif
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
            </div>
        </div>
    </div>
@endsection
