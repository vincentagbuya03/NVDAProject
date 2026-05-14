@extends('format.nav')

@section('title', 'Change Password')

@section('content')
    <div class="hero" style="padding: 2rem 0; text-align: center;">
        <div style="margin-bottom: 2rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🔐</div>
            <h1 style="margin-bottom: 0.5rem;">Change Your <span class="text-gradient">Password</span></h1>
            <p style="color: var(--text-muted); margin-bottom: 0;">This is your first login. Please update your password to continue.</p>
        </div>
    </div>

    <div style="display: flex; justify-content: center; margin-bottom: 4rem;">
        <div class="card form-card" style="width: 100%; max-width: 500px;">
            @if ($errors->any())
                <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="section-stack">
                @csrf

                <div class="field-group">
                    <label for="old_password" class="field-label">Current Password</label>
                    <input type="password" id="old_password" name="old_password" class="field-input" required autofocus>
                    @error('old_password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label for="new_password" class="field-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="field-input" required>
                    @error('new_password') <p class="field-error">{{ $message }}</p> @enderror
                    <small style="color: var(--text-muted); margin-top: 0.5rem; display: block;">Must be at least 8 characters.</small>
                </div>

                <div class="field-group">
                    <label for="new_password_confirmation" class="field-label">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="field-input" required>
                    @error('new_password_confirmation') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="action-group" style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Update Password</button>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); text-align: center;">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link" style="color: var(--text-muted); text-decoration: none;">Or logout</button>
                    </form>
                </div>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; max-width: 1000px; margin: 0 auto;">
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 1rem;">📋</div>
            <h3 style="margin-bottom: 0.5rem;">Password Requirements</h3>
            <ul style="color: var(--text-muted); list-style: none; padding: 0; margin: 0; text-align: left;">
                <li style="padding: 0.5rem 0;">✓ Minimum 8 characters</li>
                <li style="padding: 0.5rem 0;">✓ Must be different from current</li>
                <li style="padding: 0.5rem 0;">✓ Confirmation must match</li>
            </ul>
        </div>

        <div class="card" style="padding: 1.5rem; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 1rem;">🛡️</div>
            <h3 style="margin-bottom: 0.5rem;">Security Tips</h3>
            <ul style="color: var(--text-muted); list-style: none; padding: 0; margin: 0; text-align: left;">
                <li style="padding: 0.5rem 0;">• Use a strong, unique password</li>
                <li style="padding: 0.5rem 0;">• Mix letters, numbers & symbols</li>
                <li style="padding: 0.5rem 0;">• Never share your password</li>
            </ul>
        </div>
    </div>
@endsection
