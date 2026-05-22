@extends('format.nav')

@section('title', 'Add Teacher')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Add <span class="text-gradient">Teacher</span></h1>
            <p style="margin-bottom: 0;">Create a new teacher record and an automated login account.</p>
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
            <div id="teacherCreateContainer" class="section-stack" data-url="{{ route('teacher.store') }}">
                <!-- CSRF is handled by the global AJAX setup using meta tag -->

                <div class="form-divider" style="margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin: 0; color: var(--primary);">Account Credentials</h3>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="username" class="field-label">Username</label>
                        <input type="text" id="username" name="username" class="field-input" required placeholder="e.g. jsmith2024">
                    </div>

                    <div class="field-group">
                        <label for="email" class="field-label">Login Email</label>
                        <input type="email" id="email" name="email" class="field-input" required placeholder="teacher@example.com">
                    </div>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">Initial Password</label>
                    <input type="password" id="password" name="password" class="field-input" required placeholder="Minimum 8 characters">
                    <p style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">Teacher will be required to change this upon first login.</p>
                </div>

                <div class="form-divider" style="margin: 2rem 0 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin: 0; color: var(--primary);">Personal Information</h3>
                </div>

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
                </div>

                <div class="field-group">
                    <label for="profile_image" class="field-label">Profile Image (optional)</label>
                    <input type="file" id="profile_image" name="profile_image" class="field-input" accept="image/*">
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="birthdate" class="field-label">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="gender" class="field-label">Gender</label>
                        <select id="gender" name="gender" class="field-input" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="contact_no" class="field-label">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" class="field-input" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="degree_id" class="field-label">Department / Course (Degree)</label>
                    <select id="degree_id" name="degree_id" class="field-input" required>
                        <option value="">Select Department / Course</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}">
                                {{ $degree->name }} ({{ $degree->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label for="address" class="field-label">Home Address</label>
                    <textarea id="address" name="address" class="field-input" rows="3" required></textarea>
                </div>

                <div class="action-group" style="margin-top: 2rem;">
                    <button type="button" id="btnCreateTeacher" class="btn btn-primary">Create Teacher Account</button>
                    <a href="{{ route('teacher.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{ asset('js/forms.js') }}"></script>
@endsection
