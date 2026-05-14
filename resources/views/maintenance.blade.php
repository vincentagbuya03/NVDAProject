<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f172a">
    <title>Maintenance</title>
    <style>
        :root {
            --bg-1: #eef2ff;
            --bg-2: #e0f2fe;
            --panel: rgba(15, 23, 42, 0.92);
            --panel-border: rgba(255, 255, 255, 0.08);
            --text: #e5eefc;
            --muted: rgba(229, 238, 252, 0.72);
            --accent: #f97316;
            --accent-2: #60a5fa;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 20%, rgba(96, 165, 250, 0.25) 0, transparent 30%),
                radial-gradient(circle at 85% 15%, rgba(249, 115, 22, 0.2) 0, transparent 22%),
                linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 55%, #dbeafe 100%);
            overflow: hidden;
        }

        .shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.25rem;
        }

        .panel {
            width: min(760px, 100%);
            border-radius: 28px;
            background: var(--panel);
            border: 1px solid var(--panel-border);
            box-shadow: 0 24px 80px rgba(15, 23, 42, 0.35);
            overflow: hidden;
            position: relative;
        }

        .panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent 28%);
            pointer-events: none;
        }

        .panel-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 1.5rem 0;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.2), rgba(249, 115, 22, 0.24));
            border: 1px solid rgba(255, 255, 255, 0.12);
            font-size: 1.2rem;
        }

        .status {
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(249, 115, 22, 0.14);
            color: #ffd9c4;
            border: 1px solid rgba(249, 115, 22, 0.3);
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .content {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 1.25rem;
            padding: 1.4rem 1.5rem 1.5rem;
            align-items: center;
        }

        .hero {
            padding: 0.75rem 0.25rem;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(96, 165, 250, 0.14);
            color: #d7eaff;
            border: 1px solid rgba(96, 165, 250, 0.26);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        h1 {
            margin: 1rem 0 0.75rem;
            font-size: clamp(2rem, 4vw, 3.25rem);
            line-height: 1.02;
            letter-spacing: -0.03em;
        }

        .lead {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.7;
            max-width: 34rem;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn {
            appearance: none;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            min-height: 46px;
            padding: 0.85rem 1.1rem;
            border-radius: 14px;
            font-weight: 700;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
            box-shadow: 0 14px 26px rgba(59, 130, 246, 0.22);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar {
            border-radius: 22px;
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
        }

        .sidebar .label {
            color: #dbeafe;
            font-size: 0.84rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .meta-list {
            display: grid;
            gap: 0.75rem;
            margin: 0;
        }

        .meta-item {
            padding: 0.85rem 0.9rem;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .meta-item strong {
            display: block;
            margin-bottom: 0.2rem;
            color: #fff;
        }

        .meta-item span {
            color: var(--muted);
            font-size: 0.92rem;
        }

        @media (max-width: 760px) {
            .panel-top,
            .content {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .content {
                grid-template-columns: 1fr;
            }

            .panel-top {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <main class="panel" role="main" aria-labelledby="maintenance-title">
            <div class="panel-top">
                <a class="brand" href="{{ url('/') }}">
                    <span class="brand-mark">NV</span>
                    <span>NVDA</span>
                </a>
                <div class="status">Service temporarily paused</div>
            </div>

            <div class="content">
                <section class="hero">
                    <div class="eyebrow">Maintenance Notice</div>
                    <h1 id="maintenance-title">We are updating the system right now.</h1>
                    <p class="lead">The page you requested is temporarily unavailable while maintenance rules are active. Use the back button to return to the last page you viewed.</p>

                    <div class="actions">
                        <button class="btn btn-primary" type="button" onclick="goBack()">Back</button>
                    </div>
                </section>

                <aside class="sidebar" aria-label="Maintenance details">
                    <div class="label">What you can do</div>
                    <div class="meta-list">
                        <div class="meta-item">
                            <strong>Blocked route</strong>
                            <span>This page is currently unavailable.</span>
                        </div>
                        <div class="meta-item">
                            <strong>Try again later</strong>
                            <span>The site owner can restore access when maintenance is finished.</span>
                        </div>
                        <div class="meta-item">
                            <strong>Return options</strong>
                            <span>The Back button sends you to the previous page in your browser history.</span>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
                return;
            }

            window.location.href = '{{ url('/') }}';
        }
    </script>
</body>
</html>
