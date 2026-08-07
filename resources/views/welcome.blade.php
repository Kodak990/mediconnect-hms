<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Hospital Management System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap');
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --teal-dark: #064e3b; --teal: #0d7c66; --teal-mid: #14a085;
            --teal-lite: #ecfdf5; --white: #ffffff; --ink: #0f1f1b;
            --ink-mid: #374151; --ink-lite: #6b7280; --border: #d1fae5; --cream: #f0fdf8;
        }
        body { font-family: 'Inter', sans-serif; background: var(--cream); color: var(--ink); min-height: 100vh; }

        .nav { height: 68px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 40px; gap: 12px; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .nav-brand { display: flex; align-items: center; gap: 10px; flex: 1; }
        .nav-icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .nav-brand h1 { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--teal-dark); }
        .nav-links { display: flex; gap: 12px; align-items: center; }
        .btn { padding: 9px 22px; border-radius: 9px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; text-decoration: none; transition: all 0.2s; display: inline-block; }
        .btn-ghost { color: var(--ink-mid); border: 1.5px solid var(--border); background: var(--white); }
        .btn-ghost:hover { background: var(--cream); border-color: var(--teal); color: var(--teal); }
        .btn-primary { background: linear-gradient(135deg, var(--teal-dark), var(--teal)); color: white; box-shadow: 0 2px 10px rgba(13,124,102,0.3); }
        .btn-primary:hover { transform: translateY(-1px); }

        .hero { display: grid; grid-template-columns: 1fr 1fr; min-height: calc(100vh - 68px); }
        .hero-left { background: linear-gradient(150deg, var(--teal-dark), var(--teal)); padding: 72px 60px; display: flex; flex-direction: column; justify-content: center; color: white; position: relative; overflow: hidden; }
        .hero-left::after { content: ''; position: absolute; top: -80px; right: -80px; width: 320px; height: 320px; background: rgba(255,255,255,0.06); border-radius: 50%; }
        .hero-left h2 { font-family: 'Playfair Display', serif; font-size: 3rem; line-height: 1.15; margin-bottom: 20px; position: relative; }
        .hero-left h2 .accent { color: #6ee7b7; }
        .hero-left p { font-size: 1.05rem; opacity: 0.85; line-height: 1.7; margin-bottom: 36px; position: relative; max-width: 460px; }
        .hero-cta { display: flex; gap: 14px; position: relative; }
        .btn-white { background: white; color: var(--teal-dark); }
        .btn-white:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .btn-outline { background: transparent; color: white; border: 1.5px solid rgba(255,255,255,0.4); }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }

        .hero-right { padding: 72px 60px; display: flex; flex-direction: column; justify-content: center; }
        .hero-right h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--ink); margin-bottom: 28px; }
        .feature { display: flex; gap: 16px; align-items: flex-start; margin-bottom: 24px; }
        .feature-icon { width: 46px; height: 46px; border-radius: 12px; background: var(--teal-lite); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .feature-text strong { display: block; font-size: 15px; color: var(--ink); margin-bottom: 3px; }
        .feature-text span { font-size: 13.5px; color: var(--ink-lite); line-height: 1.5; }

        .footer { text-align: center; padding: 24px; font-size: 13px; color: var(--ink-lite); background: var(--white); border-top: 1px solid var(--border); }

        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; }
            .hero-left { padding: 56px 32px; }
            .hero-left h2 { font-size: 2.2rem; }
            .hero-right { padding: 48px 32px; }
            .nav { padding: 0 20px; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <div class="nav-brand">
        <div class="nav-icon">🏥</div>
        <h1>MediConnect</h1>
    </div>
    <div class="nav-links">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost">Log In</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
        @endauth
    </div>
</nav>

<div class="hero">
    <div class="hero-left">
        <h2>Healthcare that works <span class="accent">smarter</span>, not harder.</h2>
        <p>A unified telemedicine and hospital management platform built to reduce overcrowding and deliver timely, quality care to every patient.</p>
        <div class="hero-cta">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-white">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-white">Create Account</a>
                <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
            @endauth
        </div>
    </div>

    <div class="hero-right">
        <h3>Everything your facility needs, in one place.</h3>
        <div class="feature">
            <div class="feature-icon">📹</div>
            <div class="feature-text">
                <strong>Telemedicine Sessions</strong>
                <span>Schedule and track remote consultations to reduce physical congestion.</span>
            </div>
        </div>
        <div class="feature">
            <div class="feature-icon">📋</div>
            <div class="feature-text">
                <strong>Electronic Medical Records</strong>
                <span>Patient registration, consultations, and history in one searchable system.</span>
            </div>
        </div>
        <div class="feature">
            <div class="feature-icon">💊</div>
            <div class="feature-text">
                <strong>Prescriptions & Lab Results</strong>
                <span>Issue prescriptions and manage laboratory investigations end to end.</span>
            </div>
        </div>
        <div class="feature">
            <div class="feature-icon">💳</div>
            <div class="feature-text">
                <strong>Billing & Patient Portal</strong>
                <span>Automated invoicing and a self-service portal for every patient.</span>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    © 2026 MediConnect. Hospital Management System. All rights reserved.
</div>

</body>
</html>