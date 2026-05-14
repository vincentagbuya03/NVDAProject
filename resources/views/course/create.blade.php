@extends('format.nav')

@section('title', 'Create Course')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Create <span class="text-gradient">Course</span></h1>
            <p style="margin-bottom: 0;">Add a course with the same polished form treatment used across the refreshed UI.</p>
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
                
                <div class="field-group">
                    <label for="name" class="field-label">Course Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="field-input" required>
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="description" class="field-label">Description</label>
                    <textarea id="description" name="description" class="field-textarea" required>{{ old('description') }}</textarea>
                    @error('description') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="field-group">
                    <label for="degree_id" class="field-label">Assigned Degree</label>
                    <select id="degree_id" name="degree_id" class="field-input" required>
                        <option value="">Select a Degree</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                                {{ $degree->name }} ({{ $degree->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('degree_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="teacher_id" class="field-label">Assigned Teacher</label>
                    <select id="teacher_id" name="teacher_id" class="field-input">
                        <option value="">Select a Teacher (Optional)</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->fname }} {{ $teacher->lname }} ({{ $teacher->degree->name ?? 'No Degree' }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                @endif

                <div class="action-group">
                    <button type="submit" id="save_courses" class="btn btn-primary">Create Course</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="{{ asset('js/course.js') }}"></script>
@endsection
