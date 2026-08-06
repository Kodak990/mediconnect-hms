<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Sign In</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-dark:  #064e3b;
            --teal:       #0d7c66;
            --teal-glow:  rgba(13,124,102,0.15);
            --teal-lite:  #ecfdf5;
            --ink:        #0f1f1b;
            --ink-mid:    #374151;
            --ink-lite:   #6b7280;
            --error:      #dc2626;
            --error-bg:   #fef2f2;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0fdf8;
            color: var(--ink);
        }

        .left-panel {
            width: 45%;
            background: linear-gradient(160deg, #064e3b 0%, #065f46 40%, #047857 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 52px 48px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .brand { position: relative; z-index: 2; }

        .brand-icon {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: white;
            letter-spacing: -0.5px;
        }

        .brand p { color: rgba(255,255,255,0.6); font-size: 13px; margin-top: 8px; }

        .panel-content { position: relative; z-index: 2; }

        .panel-headline {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            color: white;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .panel-headline em { font-style: normal; color: #6ee7b7; }

        .panel-desc {
            color: rgba(255,255,255,0.65);
            font-size: 14px;
            line-height: 1.7;
            max-width: 340px;
        }

        .feature-list { margin-top: 36px; display: flex; flex-direction: column; gap: 14px; }

        .feature-item { display: flex; align-items: center; gap: 12px; }

        .feature-dot {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; flex-shrink: 0;
        }

        .feature-item span { color: rgba(255,255,255,0.75); font-size: 13px; }

        .panel-footer { position: relative; z-index: 2; color: rgba(255,255,255,0.35); font-size: 11px; }

        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
        }

        .form-box { width: 100%; max-width: 400px; }

        .form-header { margin-bottom: 36px; }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .form-header p { color: var(--ink-lite); font-size: 14px; }
        .form-header p a { color: var(--teal); font-weight: 600; text-decoration: none; }
        .form-header p a:hover { text-decoration: underline; }

        .error-bag {
            background: var(--error-bg);
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-mid);
            margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            pointer-events: none;
            opacity: 0.5;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #d1fae5;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background: white;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px var(--teal-glow);
        }

        .field-error { color: var(--error); font-size: 12px; margin-top: 5px; }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .remember-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--ink-mid); cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--teal); cursor: pointer;
        }

        .forgot-link { font-size: 13px; color: var(--teal); font-weight: 500; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--teal-dark), var(--teal));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(13,124,102,0.3);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(13,124,102,0.4);
        }

        .divider {
            display: flex; align-items: center; gap: 12px; margin: 24px 0;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #d1fae5; }
        .divider span { font-size: 12px; color: var(--ink-lite); white-space: nowrap; }

        .demo-box {
            background: var(--teal-lite);
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .demo-box p { font-size: 12px; color: var(--teal-dark); font-weight: 600; margin-bottom: 6px; }
        .demo-box span { display: block; font-size: 12px; color: var(--ink-mid); line-height: 1.8; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel { width: 100%; padding: 32px 24px; min-height: 200px; }
            .feature-list { display: none; }
            .right-panel { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">🏥</div>
            <h1>MediConnect</h1>
            <p>Hospital Management System</p>
        </div>

        <div class="panel-content">
            <h2 class="panel-headline">
                Healthcare that works <em>smarter,</em> not harder.
            </h2>
            <p class="panel-desc">
                A unified telemedicine and hospital management platform built to reduce overcrowding and deliver timely, quality care to every patient.
            </p>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-dot">📹</div>
                    <span>Real-time telemedicine consultations</span>
                </div>
                <div class="feature-item">
                    <div class="feature-dot">📋</div>
                    <span>Electronic medical records</span>
                </div>
                <div class="feature-item">
                    <div class="feature-dot">💊</div>
                    <span>Prescription & lab result management</span>
                </div>
                <div class="feature-item">
                    <div class="feature-dot">💳</div>
                    <span>Automated billing & invoicing</span>
                </div>
            </div>
        </div>

        <div class="panel-footer">© 2026 MediConnect. All rights reserved.</div>
    </div>

    <div class="right-panel">
        <div class="form-box">

            <div class="form-header">
                <h2>Welcome back</h2>
                <p>Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
            </div>

            @if (session('status'))
                <div class="error-bag" style="background:#ecfdf5;border-color:#a7f3d0;">
                    <p style="color:#065f46;">{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="error-bag">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">✉️</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@hospital.com" autocomplete="email" required />
                    </div>
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required />
                    </div>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me"/>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">Sign In to MediConnect</button>
            </form>

            <div class="divider"><span>Demo Accounts</span></div>

            <div class="demo-box">
                <p>🔑 Quick access credentials</p>
                <span>
                    Admin &nbsp;&nbsp;→ admin@hospital.com / admin123<br>
                    Doctor → doctor@hospital.com / doc123<br>
                    Patient → patient@hospital.com / pat123
                </span>
            </div>

        </div>
    </div>

</body>
</html>