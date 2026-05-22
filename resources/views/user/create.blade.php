@extends('format.nav')

@section('title', 'Create User')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Create <span class="text-gradient">User</span></h1>
            <p style="margin-bottom: 0;">Set up a new user account with the same upgraded form styling as the profile screens.</p>
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
            <form action="{{ route('users.store') }}" method="POST" class="section-stack">
                @csrf

                <div class="form-grid">
                    <div class="field-group">
                        <label for="username" class="field-label">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="field-input" required>
                        @error('username') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="email" class="field-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="field-input" required>
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">Password</label>
                    <input type="password" id="password" name="password" class="field-input" required>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="role" class="field-label">Role</label>
                    <select id="role" name="role" class="field-input" required>
                        <option value="">Select Role</option>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                    </select>
                    @error('role') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-divider" style="margin: 2rem 0; padding: 1rem 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin-top: 0;">Student Information</h3>
                    <p style="color: #666; font-size: 0.875rem; margin-bottom: 1rem;">All fields are required</p>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="fname" class="field-label">First Name</label>
                        <input type="text" id="fname" name="fname" value="{{ old('fname') }}" class="field-input" required>
                        @error('fname') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="mname" class="field-label">Middle Name</label>
                        <input type="text" id="mname" name="mname" value="{{ old('mname') }}" class="field-input" required>
                        @error('mname') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="lname" class="field-label">Last Name</label>
                        <input type="text" id="lname" name="lname" value="{{ old('lname') }}" class="field-input" required>
                        @error('lname') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="birthdate" class="field-label">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" class="field-input" required>
                        @error('birthdate') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="gender" class="field-label">Gender</label>
                        <select id="gender" name="gender" class="field-input" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="contact_no" class="field-label">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no') }}" class="field-input" required>
                        @error('contact_no') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label for="address" class="field-label">Address</label>
                    <textarea id="address" name="address" class="field-input" rows="3" required>{{ old('address') }}</textarea>
                    @error('address') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="degree_id" class="field-label">Degree</label>
                    <select id="degree_id" name="degree_id" class="field-input" required>
                        <option value="">Select Degree</option>
                        @foreach(\App\Models\Degree::all() as $degree)
                            <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>{{ $degree->name }}</option>
                        @endforeach
                    </select>
                    @error('degree_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Save User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
