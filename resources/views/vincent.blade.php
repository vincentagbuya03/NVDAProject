@extends('format.nav')

@section('title', 'Developer | Resource Routes')

@section('content')
    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <h1 style="margin-bottom: 0.5rem;">Resource <span class="text-gradient">Routes</span></h1>
        <p style="margin-bottom: 2rem;">API Documentation and Route Testing for StudentController.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem; margin-bottom: 4rem;">
        <!-- INDEX -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge" style="background: #eff6ff; color: #3b82f6; font-family: monospace;">GET</span>
                    <h3 style="margin: 0;">Index - Display All Students</h3>
                </div>
                <code style="background: var(--bg-main); padding: 0.25rem 0.75rem; border-radius: 4px;">/student</code>
            </div>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Returns a collection of all registered students in the system.</p>
            <a href="/student" class="btn btn-secondary" target="_blank">➜ Test Index Route</a>
        </div>

        <!-- CREATE -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge" style="background: #eff6ff; color: #3b82f6; font-family: monospace;">GET</span>
                    <h3 style="margin: 0;">Create - Show Form</h3>
                </div>
                <code style="background: var(--bg-main); padding: 0.25rem 0.75rem; border-radius: 4px;">/student/create</code>
            </div>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Displays the registration form for new student entry.</p>
            <a href="/student/create" class="btn btn-secondary" target="_blank">➜ Test Create Route</a>
        </div>

        <!-- STORE -->
        <div class="card" style="padding: 2rem; border-left: 4px solid #10b981;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge" style="background: #f0fdf4; color: #22c55e; font-family: monospace;">POST</span>
                    <h3 style="margin: 0;">Store - Save New Student</h3>
                </div>
                <code style="background: var(--bg-main); padding: 0.25rem 0.75rem; border-radius: 4px;">/student</code>
            </div>
            <form action="/student" method="POST" style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                @csrf
                <input type="text" name="name" placeholder="Enter student name" style="flex: 1; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 0.5rem;" required>
                <button type="submit" class="btn btn-primary">Save Student</button>
            </form>
            <p style="font-size: 0.875rem; color: var(--text-muted);">Processes the creation request and redirects to index.</p>
        </div>

        <!-- SHOW -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge" style="background: #eff6ff; color: #3b82f6; font-family: monospace;">GET</span>
                    <h3 style="margin: 0;">Show - Display Specific Student</h3>
                </div>
                <code style="background: var(--bg-main); padding: 0.25rem 0.75rem; border-radius: 4px;">/student/{id}</code>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="/student/1" class="btn btn-secondary" style="font-size: 0.75rem;" target="_blank">View ID 1</a>
                <a href="/student/2" class="btn btn-secondary" style="font-size: 0.75rem;" target="_blank">View ID 2</a>
            </div>
        </div>

        <!-- UPDATE -->
        <div class="card" style="padding: 2rem; border-left: 4px solid #f59e0b;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge" style="background: #fffbef; color: #d97706; font-family: monospace;">PUT</span>
                    <h3 style="margin: 0;">Update - Modify Student</h3>
                </div>
                <code style="background: var(--bg-main); padding: 0.25rem 0.75rem; border-radius: 4px;">/student/{id}</code>
            </div>
            <form action="/student/1" method="POST" style="display: flex; gap: 1rem;">
                @csrf
                @method('PUT')
                <input type="text" name="name" placeholder="Enter new name" style="flex: 1; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 0.5rem;" required>
                <button type="submit" class="btn btn-secondary">Update ID 1</button>
            </form>
        </div>

        <!-- DESTROY -->
        <div class="card" style="padding: 2rem; border-left: 4px solid var(--accent);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge" style="background: #fff1f2; color: var(--accent); font-family: monospace;">DELETE</span>
                    <h3 style="margin: 0;">Destroy - Delete Student</h3>
                </div>
                <code style="background: var(--bg-main); padding: 0.25rem 0.75rem; border-radius: 4px;">/student/{id}</code>
            </div>
            <form action="/student/1" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #fff1f2; color: var(--accent);" onclick="return confirm('Confirm deletion?')">Delete Student ID 1</button>
            </form>
        </div>
    </div>
@endsection