@extends('format.nav')

@section('title', 'Login')

@section('content')
    <div class="section-stack" style="max-width: 520px; margin: 2rem auto 4rem;">
        <div class="hero" style="padding: 1rem 0 0.5rem; text-align: left;">
            <h1 style="margin-bottom: 0.35rem;">Portal <span class="text-gradient">Login</span></h1>
            <p style="margin-bottom: 0;">Sign in to access the management pages.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
            <form action="{{ route('login.attempt') }}" method="POST" class="section-stack">
                @csrf

                <div class="field-group">
                    <label for="email" class="field-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="field-input" required autofocus>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">Password</label>
                    <input type="password" id="password" name="password" class="field-input" required>
                </div>

                <div class="field-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="field-label" style="margin-bottom: 0;">Remember me</label>
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
