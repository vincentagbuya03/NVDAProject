@extends('format.nav')

@section('title', 'Student Dashboard')

@section('content')
    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <h1 style="margin-bottom: 0.5rem;">Student <span class="text-gradient">Dashboard</span></h1>
        <p style="margin-bottom: 2rem;">Welcome back, {{ $student->fname ?? $user->username }}. Here is your academic progress.</p>
    </div>

    <!-- Stats Row -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="card" style="padding: 2rem; border-left: 4px solid var(--primary);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <span style="font-size: 0.875rem; font-weight: 700; color: #666; text-transform: uppercase;">Enrolled Courses</span>
                <span style="font-size: 1.5rem;">📚</span>
            </div>
            <h2 style="font-size: 2.5rem; margin: 0;">{{ $enrolledCourses->count() }}</h2>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--primary); font-weight: 600;">
                Current Semester
            </div>
        </div>

        <div class="card" style="padding: 2rem; border-left: 4px solid #10b981;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <span style="font-size: 0.875rem; font-weight: 700; color: #666; text-transform: uppercase;">Average Grade</span>
                <span style="font-size: 1.5rem;">⭐</span>
            </div>
            @php
                $grades = $enrolledCourses->pluck('grade')->filter()->map(fn($g) => floatval($g));
                $avg = $grades->count() > 0 ? number_format($grades->average(), 2) : 'N/A';
            @endphp
            <h2 style="font-size: 2.5rem; margin: 0;">{{ $avg }}</h2>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: #10b981; font-weight: 600;">
                Academic Standing
            </div>
        </div>

        <div class="card" style="padding: 2rem; border-left: 4px solid var(--secondary);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <span style="font-size: 0.875rem; font-weight: 700; color: #666; text-transform: uppercase;">Completed</span>
                <span style="font-size: 1.5rem;">✅</span>
            </div>
            <h2 style="font-size: 2.5rem; margin: 0;">{{ $enrolledCourses->where('status', 'completed')->count() }}</h2>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: #666;">
                Earned Credits
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 4rem;">
        <!-- My Courses Table -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="margin: 0;">My Enrolled Courses</h3>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Browse Catalog</a>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #666;">Course</th>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #666;">Instructor</th>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #666;">Status</th>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #666;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrolledCourses as $enrollment)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1.25rem 1rem;">
                                    <div style="font-weight: 600;">{{ $enrollment->course->name }}</div>
                                    <div style="font-size: 0.75rem; color: #666;">ID: #{{ $enrollment->course->id }}</div>
                                </td>
                                <td style="padding: 1rem; color: #444;">
                                    {{ $enrollment->course->teacher ? 'Prof. ' . $enrollment->course->teacher->lname : 'TBA' }}
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="badge {{ $enrollment->status === 'completed' ? 'badge-success' : 'badge-primary' }}" style="text-transform: capitalize;">
                                        {{ $enrollment->status }}
                                    </span>
                                </td>
                                <td style="padding: 1rem; font-weight: 700; color: var(--secondary);">
                                    {{ $enrollment->grade ?? '--' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 3rem; text-align: center; color: #666;">
                                    You are not enrolled in any courses yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Announcements -->
        <div class="card" style="padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Announcements</h3>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @forelse($latestPosts as $post)
                    <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <p style="margin: 0; font-weight: 600; font-size: 0.95rem;">{{ $post->title }}</p>
                        <p style="margin: 0.25rem 0; font-size: 0.8125rem; color: #666; line-height: 1.4;">
                            {{ Str::limit($post->content, 80) }}
                        </p>
                        <small style="color: var(--primary); font-size: 0.75rem;">
                            {{ $post->user->name }} &bull; {{ $post->created_at->diffForHumans() }}
                        </small>
                    </div>
                @empty
                    <p style="color: #666; font-size: 0.875rem;">No recent announcements.</p>
                @endforelse
            </div>
            <a href="{{ route('posts.index') }}" class="btn btn-primary" style="margin-top: 2rem; width: 100%;">View All Posts</a>
        </div>
    </div>
@endsection