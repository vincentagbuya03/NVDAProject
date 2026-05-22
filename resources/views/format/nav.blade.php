<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | NVDA Project</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="/css/modern.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .logo { font-family: 'Outfit', sans-serif; }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 70%;
        }
        
        .main-gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(circle at 0% 0%, rgba(99, 102, 241, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(14, 165, 233, 0.03) 0%, transparent 50%);
            pointer-events: none;
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <div class="main-gradient-bg"></div>

    @section('header')
        <nav>
            <div class="nav-container">
                <a href="/" class="logo">NVDA<span style="color: var(--text-main)">.</span></a>
                <ul>
                    <li>
                        @if(Auth::check() && Auth::user()->role === 'teacher')
                            <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->is('teacher-dashboard*') ? 'active' : '' }}">Dashboard</a>
                        @elseif(Auth::check() && Auth::user()->role === 'student')
                            <a href="{{ route('clientDashboard') }}" class="nav-link {{ request()->is('clientDashboard*') ? 'active' : '' }}">Dashboard</a>
                        @else
                            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') || request()->is('home') ? 'active' : '' }}">Dashboard</a>
                        @endif
                    </li>
                    
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li><a href="{{ url('/students') }}" class="nav-link {{ request()->is('students*') ? 'active' : '' }}">Students</a></li>
                        <li><a href="{{ route('degrees.index') }}" class="nav-link {{ request()->is('degrees*') ? 'active' : '' }}">Degrees</a></li>
                        <li><a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">Users</a></li>
                        <li><a href="{{ route('course_students.index') }}" class="nav-link {{ request()->is('course_students*') ? 'active' : '' }}">Course Student</a></li>
                        <li><a href="{{ route('maintenance-manager.index') }}" class="nav-link {{ request()->is('maintenance-manager*') ? 'active' : '' }}">Maintenance</a></li>
                        <li><a href="{{ route('teacher.index') }}" class="nav-link {{ request()->is('teacher*') ? 'active' : '' }}">Teacher</a></li>
                    @endif



                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li><a href="{{ route('profiles.index') }}" class="nav-link {{ request()->is('profiles*') ? 'active' : '' }}">Profiles</a></li>
                    @elseif(Auth::check() && Auth::user()->role === 'teacher')
                        <li><a href="{{ route('clientProfile') }}" class="nav-link {{ request()->is('clientProfile*') ? 'active' : '' }}">My Profile</a></li>
                    @else
                        <li><a href="{{ route('clientProfile') }}" class="nav-link {{ request()->is('clientProfile*') ? 'active' : '' }}">My Profile</a></li>
                    @endif

                    <li><a href="{{ route('posts.index') }}" class="nav-link {{ request()->is('posts*') ? 'active' : '' }}">Post</a></li>
                    <li><a href="{{ route('courses.index') }}" class="nav-link {{ request()->is('courses*') ? 'active' : '' }}">Course</a></li>
                    <li><a href="{{ url('/clientAboutUs') }}" class="nav-link {{ request()->is('clientAboutUs*') ? 'active' : '' }}">About</a></li>
                </ul>
                <div class="nav-actions">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1.25rem;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 0.5rem 1.25rem;">Portal Login</a>
                    @endauth
                </div>
            </div>
        </nav>
    @show

    <div id="globalModal" class="login-modal-overlay" style="display: none;">
        <div class="login-modal-card" style="width: min(900px, 95%); max-height: 90vh; overflow-y: auto;">
            <button type="button" class="login-modal-close" onclick="$('#globalModal').fadeOut(200)">x</button>
            <div id="modalContent" style="margin-top: 1rem;">
                <!-- AJAX Content Loads Here -->
            </div>
        </div>
    </div>

    <main class="container fade-in">
        @yield('content')
    </main>

    @if (session('login_success'))
        <div class="login-modal-overlay" id="loginSuccessModal" role="dialog" aria-modal="true" aria-labelledby="loginSuccessTitle">
            <div class="login-modal-card">
                <button type="button" class="login-modal-close" id="loginSuccessClose" aria-label="Close login success message">x</button>
                <p class="login-modal-chip">Login Successful</p>
                <h2 id="loginSuccessTitle">You are signed in</h2>
                <p>{{ session('login_success_message', 'Welcome! Your login was successful.') }}</p>
                <button type="button" class="btn btn-primary" id="loginSuccessOkay">Continue</button>
            </div>
        </div>
    @endif

    @section('footer')
        <footer>
            <div class="container" style="padding: 0 2rem;">
                <div style="margin-bottom: 2rem;">
                    <a href="/" class="logo" style="font-size: 1.25rem;">NVDA<span style="color: var(--text-main)">.</span></a>
                    <p style="margin-top: 1rem; max-width: 300px; margin-left: auto; margin-right: auto;">
                        A premium client management system designed for innovation and productivity.
                    </p>
                </div>
                <div style="border-top: 1px solid var(--border-color); padding-top: 2rem;">
                    <p>&copy; 2026 Vincent Agbuya. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @show

    @if (session('login_success'))
        <script>
            (function () {
                const modal = document.getElementById('loginSuccessModal');
                const closeBtn = document.getElementById('loginSuccessClose');
                const okayBtn = document.getElementById('loginSuccessOkay');

                if (!modal || !closeBtn || !okayBtn) {
                    return;
                }

                const closeModal = () => {
                    modal.classList.add('is-closing');
                    window.setTimeout(() => {
                        modal.remove();
                    }, 180);
                };

                closeBtn.addEventListener('click', closeModal);
                okayBtn.addEventListener('click', closeModal);

                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        closeModal();
                    }
                });
            })();
        </script>
    @endif

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @yield('extra-js')
</body>
</html>
