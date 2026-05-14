@extends('format.nav')

@section('title', 'Edit Degree')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.4rem;">Edit <span class="text-gradient">Degree</span></h1>
            <p style="margin-bottom: 0;">Update degree details while keeping the same shared UI language across the system.</p>
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
            <form action="{{ route('degrees.update', $degree->id) }}" method="POST" class="section-stack">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field-group">
                        <label for="name" class="field-label">Degree Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $degree->name) }}" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label for="code" class="field-label">Degree Code</label>
                        <input type="text" id="code" name="code" value="{{ old('code', $degree->code) }}" class="field-input" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="department" class="field-label">Department</label>
                    <input type="text" id="department" name="department" value="{{ old('department', $degree->department) }}" class="field-input" required>
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">Update Degree</button>
                    <a href="{{ route('degrees.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
