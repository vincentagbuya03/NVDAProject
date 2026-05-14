@extends('format.nav')

@section('title', 'Edit Course Student')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">Assignment</span></h1>
            <p style="margin-bottom: 0;">Adjust the student-course relationship with the same consistent refreshed UI.</p>
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
            <form action="{{ route('course_students.update', $courseStudent->id) }}" method="POST" class="section-stack">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field-group">
                        <label for="student_id" class="field-label">Student</label>
                        <select id="student_id" name="student_id" class="field-select" required>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id', $courseStudent->student_id) == $student->id ? 'selected' : '' }}>{{ $student->fname }} {{ $student->lname }}</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="course_id" class="field-label">Course</label>
                        <select id="course_id" name="course_id" class="field-select" required>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $courseStudent->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Update Assignment</button>
                    <a href="{{ route('course_students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
