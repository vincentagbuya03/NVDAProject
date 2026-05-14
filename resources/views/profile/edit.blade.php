@extends('format.nav')

@section('title', 'Edit Profile')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">Profile</span></h1>
            <p style="margin-bottom: 0;">Update bio, image URL, and status for {{ $profile->user->name ?? 'this user' }}.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
            <form action="{{ route('profiles.update', $profile->id) }}" method="POST" class="section-stack">
                @csrf
                @method('PUT')

                <div class="field-group">
                    <label for="bio" class="field-label">Bio</label>
                    <textarea id="bio" name="bio" class="field-input" rows="5" placeholder="Write a short bio...">{{ old('bio', $profile->bio) }}</textarea>
                    <p class="field-help">Leave this blank if you do not want a bio.</p>
                    @error('bio') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="image_url" class="field-label">Profile Image URL</label>
                    <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $profile->image_url) }}" class="field-input" placeholder="https://example.com/photo.jpg">
                    @error('image_url') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="status" class="field-label">Status</label>
                    <select id="status" name="status" class="field-select" required>
                        <option value="active" {{ old('status', $profile->status ?? 'inactive') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $profile->status ?? 'inactive') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
