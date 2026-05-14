@extends('format.nav')

@section('title', 'Edit User')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">User</span></h1>
            <p style="margin-bottom: 0;">Update account details using the same refreshed admin UI pattern.</p>
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
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="section-stack">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field-group">
                        <label for="username" class="field-label">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" class="field-input" required>
                        @error('username') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="email" class="field-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="field-input" required>
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">New Password</label>
                    <input type="password" id="password" name="password" class="field-input">
                    <p class="field-help">Leave this blank to keep the current password.</p>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="role" class="field-label">Role</label>
                    <select id="role" name="role" class="field-input">
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
                    </select>
                    @error('role') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                @php
                    $student = $user->student;
                @endphp

                <div class="form-divider" style="margin: 2rem 0; padding: 1rem 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin-top: 0;">Student Information</h3>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="fname" class="field-label">First Name</label>
                        <input type="text" id="fname" name="fname" value="{{ old('fname', $student->fname ?? '') }}" class="field-input">
                        @error('fname') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="mname" class="field-label">Middle Name</label>
                        <input type="text" id="mname" name="mname" value="{{ old('mname', $student->mname ?? '') }}" class="field-input">
                        @error('mname') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="lname" class="field-label">Last Name</label>
                        <input type="text" id="lname" name="lname" value="{{ old('lname', $student->lname ?? '') }}" class="field-input">
                        @error('lname') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="field-group">
                        <label for="age" class="field-label">Age</label>
                        <input type="number" id="age" name="age" value="{{ old('age', $student->age ?? '') }}" class="field-input" min="1">
                        @error('age') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="gender" class="field-label">Gender</label>
                        <select id="gender" name="gender" class="field-input">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $student->gender ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $student->gender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label for="contact_no" class="field-label">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no', $student->contact_no ?? '') }}" class="field-input">
                        @error('contact_no') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label for="address" class="field-label">Address</label>
                    <textarea id="address" name="address" class="field-input" rows="3">{{ old('address', $student->address ?? '') }}</textarea>
                    @error('address') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="degree_id" class="field-label">Degree</label>
                    <select id="degree_id" name="degree_id" class="field-input">
                        <option value="">Select Degree (Optional)</option>
                        @foreach(\App\Models\Degree::all() as $degree)
                            <option value="{{ $degree->id }}" {{ old('degree_id', $student->degree_id ?? '') == $degree->id ? 'selected' : '' }}>{{ $degree->name }}</option>
                        @endforeach
                    </select>
                    @error('degree_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
