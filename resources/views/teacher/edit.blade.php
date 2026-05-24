@extends('format.nav')

@section('title', 'Edit Teacher')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">Teacher</span></h1>
            <p style="margin-bottom: 0;">Update teacher information and linked account settings.</p>
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
            <div id="teacherEditContainer" class="section-stack" data-url="{{ route('teacher.update', $teacher->id) }}" data-method="PUT">
                <div class="form-divider" style="margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin: 0; color: var(--primary);">Account Credentials</h3>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="username" class="field-label">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', optional($teacher->user)->username) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="email" class="field-label">Login Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $teacher->email) }}" class="field-input" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">New Password (leave blank to keep current)</label>
                    <input type="password" id="password" name="password" class="field-input" placeholder="Min 8 characters">
                </div>

                <div class="form-divider" style="margin: 2rem 0 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin: 0; color: var(--primary);">Personal Information</h3>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="fname" class="field-label">First Name</label>
                        <input type="text" id="fname" name="fname" value="{{ old('fname', $teacher->fname) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="mname" class="field-label">Middle Name</label>
                        <input type="text" id="mname" name="mname" value="{{ old('mname', $teacher->mname) }}" class="field-input">
                    </div>

                    <div class="field-group">
                        <label for="lname" class="field-label">Last Name</label>
                        <input type="text" id="lname" name="lname" value="{{ old('lname', $teacher->lname) }}" class="field-input" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="profile_image" class="field-label">Profile Image (optional)</label>
                    @if(!empty($teacher->user?->profile?->image_url))
                        <div style="margin-bottom: 0.75rem;">
                            <img src="{{ str_starts_with($teacher->user->profile->image_url, 'http') ? $teacher->user->profile->image_url : asset($teacher->user->profile->image_url) }}" alt="Teacher profile" style="width: 96px; height: 96px; border-radius: 999px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" id="profile_image" name="profile_image" class="field-input" accept="image/*">
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="birthdate" class="field-label">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $teacher->birthdate) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="gender" class="field-label">Gender</label>
                        <select id="gender" name="gender" class="field-input" required>
                            <option value="Male" {{ old('gender', $teacher->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $teacher->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $teacher->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="contact_no" class="field-label">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no', $teacher->contact_no) }}" class="field-input" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="degree_id" class="field-label">Department / Course (Degree)</label>
                    <select id="degree_id" name="degree_id" class="field-input" required>
                        <option value="">Select Department / Course</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}" {{ old('degree_id', $teacher->degree_id) == $degree->id ? 'selected' : '' }}>
                                {{ $degree->name }} ({{ $degree->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label for="address" class="field-label">Home Address</label>
                    <textarea id="address" name="address" class="field-input" rows="3" required>{{ old('address', $teacher->address) }}</textarea>
                </div>

                <div class="action-group" style="margin-top: 2rem;">
                    <button type="button" id="btnEditTeacher" class="btn btn-primary">Update Teacher Account</button>
                    <a href="{{ route('teacher.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{ asset('js/forms.js') }}"></script>
@endsection
