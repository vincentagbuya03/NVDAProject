@extends('format.nav')

@section('title', 'Create Post')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Create <span class="text-gradient">Post</span></h1>
            <p style="margin-bottom: 0;">Compose a post using the same modern form layout as the other admin pages.</p>
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
            <form action="{{ route('posts.store') }}" method="POST" class="section-stack">
                @csrf

                @if(auth()->user()->role === 'admin')
                <div class="field-group">
                    <label for="user_id" class="field-label">User</label>
                    <select id="user_id" name="user_id" class="field-select" required>
                        <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Select user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                @endif

                <div class="field-group">
                    <label for="title" class="field-label">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="field-input" required>
                    @error('title') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="content" class="field-label">Content</label>
                    <textarea id="content" name="content" class="field-textarea" required>{{ old('content') }}</textarea>
                    @error('content') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Save Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
