@extends('format.nav')

@section('title', 'Create Course Student')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Create <span class="text-gradient">Assignment</span></h1>
            <p style="margin-bottom: 0;">Link a student to a course using the shared modern form design.</p>
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
            <form action="{{ route('course_students.store') }}" method="POST" class="section-stack">
                @csrf

                <div class="form-grid">
                    <div class="field-group">
                        <label for="student_id" class="field-label">Student</label>
                        <select id="student_id" name="student_id" class="field-select" required>
                            <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>Select student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->fname }} {{ $student->lname }}</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="course_id" class="field-label">Course</label>
                        <select id="course_id" name="course_id" class="field-select" required>
                            <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>Select course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Save Assignment</button>
                    <a href="{{ route('course_students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
