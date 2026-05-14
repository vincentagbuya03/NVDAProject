<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EduManage - Student Management Dashboard">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title', 'EduManage - Student Management Dashboard')</title>
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
            background-color: #f8f9fa;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }
        
        /* Navbar Styles */
        nav {
            background: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid #e5e7eb;
        }
        
        nav ul {
            display: flex;
            gap: 0;
            list-style: none;
            max-width: 1400px;
            margin: 0 auto;
            align-items: center;
            justify-items: space-between;
            width: 100%;
        }
        
        nav .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-right: 3rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: #1e40af;
            text-decoration: none;
        }
        
        nav .logo span {
            background: linear-gradient(135deg, #1e40af 0%, #0284c7 100%);
            color: white;
            padding: 0.35rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 1rem;
        }
        
        nav .nav-center {
            display: flex;
            gap: 0.5rem;
            margin-right: auto;
        }
        
        nav a {
            color: #6b7280;
            text-decoration: none;
            padding: 0.625rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9375rem;
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            border: 1px solid transparent;
        }
        
        nav a.active {
            color: #1e40af;
            border-bottom: 2px solid #1e40af;
        }
        
        nav a:hover {
            color: #1e40af;
            background-color: #f0f4ff;
        }
        
        nav a:focus {
            outline: 2px solid #1e40af;
            outline-offset: 2px;
        }
        
        nav .nav-right {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-left: auto;
        }
        
        nav .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        nav .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }
        
        /* Main Content */
        main {
            padding: 2rem;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }
        
        main h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        
        main > p {
            color: #6b7280;
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
        }
        
        /* Footer Styles */
        footer {
            background: #ffffff;
            color: #6b7280;
            padding: 2rem;
            margin-top: auto;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 0.875rem;
        }
        
        footer p {
            margin: 0.25rem 0;
        }
        
        footer a {
            color: #1e40af;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: #0284c7;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            nav {
                padding: 0.75rem 1rem;
            }
            
            nav ul {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            nav .logo {
                margin-right: auto;
                font-size: 1rem;
            }
            
            nav .logo span {
                padding: 0.25rem 0.375rem;
                font-size: 0.875rem;
            }
            
            nav .nav-center {
                display: none;
            }
            
            nav a {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
            }
            
            main {
                padding: 1rem;
            }
            
            main h1 {
                font-size: 1.5rem;
            }
            
            nav .nav-right {
                gap: 0.5rem;
            }
            
            nav .user-avatar {
                width: 2rem;
                height: 2rem;
                font-size: 0.875rem;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        main > * {
            animation: fadeIn 0.5s ease-out;
        }
        
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVJkEZSMUkrQ6usKu8zIvmarPhyZqstHrnUUfunP4XwSjrW+pxBCXeoBTo7ZRj3948M1B7Cym0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navigation -->
    <nav role="navigation" aria-label="Main navigation">
        <ul>
            <li class="logo">
                <a href="{{ url('/') }}" title="EduManage Dashboard">
                    <span>📚</span> EDUMANAGE
                </a>
            </li>
            <li class="nav-center">
                <a href="{{ url('/') }}" title="Dashboard" @class(['active' => request()->is('/') || request()->is('home')])>Dashboard</a>
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ url('/students') }}" title="Students" @class(['active' => request()->is('students*')])>Students</a>
                    <a href="{{ route('degrees.index') }}" title="Degrees" @class(['active' => request()->is('degrees*')])>Degrees</a>
                    <a href="{{ route('users.index') }}" title="Users" @class(['active' => request()->is('users*')])>Users</a>
                    <a href="{{ route('course_students.index') }}" title="Course Student" @class(['active' => request()->is('course_students*')])>Course Student</a>
                @endif

                <a href="{{ route('posts.index') }}" title="Post" @class(['active' => request()->is('posts*')])>Post</a>
                <a href="{{ route('courses.index') }}" title="Course" @class(['active' => request()->is('courses*')])>Course</a>
                <a href="{{ url('/about') }}" title="About" @class(['active' => request()->is('about*')])>About</a>
            </li>
            <li class="nav-right">
                <a href="{{ Auth::user()->role === 'admin' ? route('profiles.index') : route('clientProfile') }}" style="text-decoration: none;">
                    <div class="user-avatar" title="User Profile">{{ strtoupper(substr(Auth::user()->username, 0, 3)) }}</div>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main role="main" id="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer role="contentinfo">
        <p>&copy; 2024 EduManage Student Information System. All rights reserved.</p>
