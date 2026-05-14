@extends('format.nav')

@section('title', 'Add Degree')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Add <span class="text-gradient">Degree</span></h1>
            <p style="margin-bottom: 0;">Create a new degree record using the same polished form layout as the profile module.</p>
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
            <form action="{{ route('degrees.store') }}" method="POST" class="section-stack">
                @csrf

                <div class="form-grid">
                    <div class="field-group">
                        <label for="name" class="field-label">Degree Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="code" class="field-label">Degree Code</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}" class="field-input" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="department" class="field-label">Department</label>
                    <input type="text" id="department" name="department" value="{{ old('department') }}" class="field-input" required>
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Add Degree</button>
                    <a href="{{ route('degrees.index') }}" class="btn btn-secondary">Back to Degrees</a>
                </div>
            </form>
        </div>
    </div>
@endsection
