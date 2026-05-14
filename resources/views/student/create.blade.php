@extends('format.nav')

@section('title', 'Add Student')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Add <span class="text-gradient">Student</span></h1>
            <p style="margin-bottom: 0;">Create a student profile with a cleaner, profile-style form layout.</p>
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
            <div id="studentCreateContainer" class="section-stack" data-url="{{ route('students.store') }}">
                <!-- CSRF is handled by the global AJAX setup using meta tag -->

                <div class="form-grid">
                    <div class="field-group">
                        <label for="fname" class="field-label">First Name</label>
                        <input type="text" id="fname" name="fname" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="mname" class="field-label">Middle Name</label>
                        <input type="text" id="mname" name="mname" class="field-input">
                    </div>

                    <div class="field-group">
                        <label for="lname" class="field-label">Last Name</label>
                        <input type="text" id="lname" name="lname" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="birthdate" class="field-label">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="gender" class="field-label">Gender</label>
                        <select id="gender" name="gender" class="field-select" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Boy">Boy</option>
                            <option value="Girl">Girl</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="contact_no" class="field-label">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="degree_id" class="field-label">Course</label>
                        <select name="degree_id" id="degree_id" class="field-select" required>
                            <option value="" disabled selected>Select a course</option>
                            @foreach ($degrees as $degree)
                                <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field-group">
                    <label for="address" class="field-label">Address</label>
                    <textarea id="address" name="address" class="field-textarea" required></textarea>
                </div>

                <div class="field-group">
                    <label for="email" class="field-label">Email Address</label>
                    <input type="email" id="email" name="email" class="field-input" required>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">Its Temporary Password (will be shown to student)</label>
                    <input type="text" id="password" name="password" class="field-input" placeholder="Leave blank to auto-generate">
                    <small style="color: var(--text-muted); margin-top: 0.5rem; display: block;">Students will be required to change this password on first login.</small>
                </div>

                <div class="action-group">
                    <button type="button" id="btnCreateStudent" class="btn btn-primary">Add Student</button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{ asset('js/forms.js') }}"></script>
@endsection
