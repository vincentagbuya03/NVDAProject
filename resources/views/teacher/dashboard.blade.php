@extends('format.nav')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="section-stack">
        <div class="hero" style="padding: 2rem 0; text-align: left;">
            <h1 style="margin-bottom: 0.5rem;">Welcome, <span class="text-gradient">Prof. {{ $teacher->lname }}</span></h1>
            <p style="margin-bottom: 0;">Access your teaching dashboard and faculty resources.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
            <!-- Profile Overview Card -->
            <div class="card" style="padding: 1.5rem; border-top: 4px solid var(--primary);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 64px; height: 64px; border-radius: 12px; background: var(--bg-main); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; color: var(--primary); border: 2px solid var(--border-color);">
                        {{ substr($teacher->fname, 0, 1) }}{{ substr($teacher->lname, 0, 1) }}
                    </div>
                    <div>
                        <h3 style="margin: 0;">{{ $teacher->fname }} {{ $teacher->lname }}</h3>
                        <p style="margin: 0; font-size: 0.875rem; color: #666;">{{ $teacher->course }} Faculty</p>
                    </div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                        <span style="color: #666;">Email:</span>
                        <span style="font-weight: 500;">{{ $teacher->email }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                        <span style="color: #666;">Contact:</span>
                        <span style="font-weight: 500;">{{ $teacher->contact_no }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                        <span style="color: #666;">Status:</span>
                        <span class="badge badge-success">Active</span>
                    </div>
                </div>
            </div>

            <!-- Teaching Stats Card -->
            <div class="card" style="padding: 1.5rem; border-top: 4px solid var(--secondary);">
                <h3 style="margin-bottom: 1rem;">Teaching Overview</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="background: var(--bg-main); padding: 1rem; border-radius: 8px; text-align: center;">
                        <p style="margin: 0; font-size: 0.75rem; color: #666; text-transform: uppercase;">Classes</p>
                        <p style="margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--secondary);">{{ $totalClasses }}</p>
                    </div>
                    <div style="background: var(--bg-main); padding: 1rem; border-radius: 8px; text-align: center;">
                        <p style="margin: 0; font-size: 0.75rem; color: #666; text-transform: uppercase;">Students</p>
                        <p style="margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--secondary);">{{ $totalStudents }}</p>
                    </div>
                </div>
                <button class="btn btn-secondary" style="width: 100%; margin-top: 1rem;">Faculty Resources</button>
            </div>
        </div>

        <div class="card table-card" style="margin-bottom: 2.5rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">My Assigned <span class="text-gradient">Courses</span></h3>
                <span class="badge badge-primary">{{ $totalClasses }} Active</span>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Description</th>
                            <th>Enrolled</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teacher->courses as $course)
                            <tr>
                                <td style="font-weight: 600;">{{ $course->name }}</td>
                                <td style="color: #666; font-size: 0.875rem;">{{ Str::limit($course->description, 60) }}</td>
                                <td><span class="badge badge-secondary">{{ $course->students->count() }} Students</span></td>
                                <td>
                                    <a href="{{ route('teacher.course.students', $course->id) }}" class="btn btn-primary" style="padding: 0.35rem 0.75rem; font-size: 0.8125rem;">Manage Students</a>
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.8125rem;">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No courses assigned to you yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" style="padding: 2rem; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">👨‍🏫</div>
            <h2>Faculty Portal</h2>
            <p style="color: #666; max-width: 500px; margin: 0 auto 1.5rem;">Welcome to the new faculty dashboard. Here you can manage your assignments, view student rosters, and update your professional profile.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('posts.index') }}" class="btn btn-primary">Check Announcements</a>
                <a href="{{ route('clientProfile') }}" class="btn btn-secondary">Update Profile</a>
            </div>
        </div>
    </div>
@endsection
