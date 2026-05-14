@extends('format.nav')

@section('title', 'Edit Post')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">Post</span></h1>
            <p style="margin-bottom: 0;">Update post details while keeping the UI aligned with the rest of the system.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card form-card">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" class="section-stack">
                @csrf
                @method('PUT')

                <div class="field-group">
                    <label for="user_id" class="field-label">User</label>
                    <select id="user_id" name="user_id" class="field-select" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="title" class="field-label">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" class="field-input" required>
                    @error('title') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="content" class="field-label">Content</label>
                    <textarea id="content" name="content" class="field-textarea" required>{{ old('content', $post->content) }}</textarea>
                    @error('content') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
