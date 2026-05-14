@extends('format.nav')

@section('title', 'Edit Student')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">Student</span></h1>
            <p style="margin-bottom: 0;">Refine student information using the same UI pattern as the rest of the refreshed system.</p>
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
            <div id="studentEditContainer" class="section-stack" data-url="{{ route('students.update', $student->id) }}" data-method="PUT">
                <div class="form-grid">
                    <div class="field-group">
                        <label for="fname" class="field-label">First Name</label>
                        <input type="text" id="fname" name="fname" value="{{ old('fname', $student->fname) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="mname" class="field-label">Middle Name</label>
                        <input type="text" id="mname" name="mname" value="{{ old('mname', $student->mname) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="lname" class="field-label">Last Name</label>
                        <input type="text" id="lname" name="lname" value="{{ old('lname', $student->lname) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="birthdate" class="field-label">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="gender" class="field-label">Gender</label>
                        <select id="gender" name="gender" class="field-select" required>
                            <option value="" disabled>Select Gender</option>
                            <option value="Boy" {{ old('gender', $student->gender) == 'Boy' ? 'selected' : '' }}>Boy</option>
                            <option value="Girl" {{ old('gender', $student->gender) == 'Girl' ? 'selected' : '' }}>Girl</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="contact_no" class="field-label">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no', $student->contact_no) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="degree_id" class="field-label">Course</label>
                        <select id="degree_id" name="degree_id" class="field-select" required>
                            <option value="" disabled>Select a course</option>
                            @foreach ($degrees as $degree)
                                <option value="{{ $degree->id }}" {{ old('degree_id', $student->degree_id) == $degree->id ? 'selected' : '' }}>{{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field-group">
                    <label for="address" class="field-label">Address</label>
                    <textarea id="address" name="address" class="field-textarea" required>{{ old('address', $student->address) }}</textarea>
                </div>

                <div class="action-group">
                    <button type="button" id="btnEditStudent" class="btn btn-primary">Update Student</button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{ asset('js/forms.js') }}"></script>
@endsection
