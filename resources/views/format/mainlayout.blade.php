<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | NVDA Project</title>
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f093fb;
            --bg: #f5f7fa;
            --card-bg: #ffffff;
            --text: #2d3748;
            --text-light: #718096;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            line-height: 1.6;
            color: var(--text);
            min-height: 100vh;
        }
        
        nav {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 20px 30px;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }
        
        nav ul {
            list-style-type: none;
            display: flex;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 10px 18px;
            border-radius: 8px;
            position: relative;
        }
        
        nav a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.8);
            transform: translateX(-50%);
            transition: width 0.4s ease;
        }
        
        nav a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
        }
        
        nav a:hover::before {
            width: 100%;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        
        footer {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            text-align: center;
            padding: 40px 30px;
            margin-top: 80px;
            box-shadow: var(--shadow);
        }
        
        main {
            flex: 1;
        }

        .main-content {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 40px;
            min-height: 400px;
        }

        .page-header {
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid #edf2f7;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 6px;
        }

        .page-header p {
            color: var(--text-light);
            font-size: 15px;
        }

        @media (max-width: 768px) {
            nav ul {
                gap: 20px;
            }
            .container {
                padding: 40px 15px;
            }
            .main-content {
                padding: 24px 18px;
            }
            .page-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @section('header')
        <nav>
            <ul>
                <li><a href="/clientProfile">Home</a></li>
                <li><a href="/clientDashboard">Student</a></li>
                <li><a href="/clientAboutUs">About</a></li>
            </ul>
        </nav>
    @show
    <main>
        <div class="container">
            <div class="main-content">
                @hasSection('page-header')
                    <div class="page-header">
                        @yield('page-header')
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </main>
    @section('footer')
        <footer>
            <p>&copy; 2026 Nick Vincent Agbuya. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">Professional Client Management System</p>
        </footer>
    @show
</body>
</html>