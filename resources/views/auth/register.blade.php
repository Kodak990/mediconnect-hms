<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Create Account</title>
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

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
            font-size: 24px; margin-bottom: 20px;
        }

        .brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; color: white; letter-spacing: -0.5px;
        }

        .brand p { color: rgba(255,255,255,0.6); font-size: 13px; margin-top: 8px; }

        .panel-content { position: relative; z-index: 2; }

        .panel-headline {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; color: white; line-height: 1.2; margin-bottom: 16px;
        }

        .panel-headline em { font-style: normal; color: #6ee7b7; }

        .panel-desc { color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.7; }

        .steps { margin-top: 36px; display: flex; flex-direction: column; gap: 16px; }

        .step { display: flex; align-items: flex-start; gap: 14px; }

        .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: #6ee7b7; font-size: 12px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }

        .step-text strong { display: block; color: white; font-size: 13px; font-weight: 600; margin-bottom: 2px; }
        .step-text span { color: rgba(255,255,255,0.55); font-size: 12px; }

        .panel-footer { position: relative; z-index: 2; color: rgba(255,255,255,0.35); font-size: 11px; }

        .right-panel {
            flex: 1; display: flex; align-items: center;
            justify-content: center; padding: 40px 48px; overflow-y: auto;
        }

        .form-box { width: 100%; max-width: 420px; }

        .form-header { margin-bottom: 30px; }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem; color: var(--ink); margin-bottom: 6px;
        }

        .form-header p { color: var(--ink-lite); font-size: 14px; }
        .form-header p a { color: var(--teal); font-weight: 600; text-decoration: none; }
        .form-header p a:hover { text-decoration: underline; }

        .error-bag {
            background: var(--error-bg); border: 1px solid #fecaca;
            border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;
        }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }

        .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block; font-size: 13px; font-weight: 600;
            color: var(--ink-mid); margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%); font-size: 14px;
            pointer-events: none; opacity: 0.45;
        }

        .form-group input,
        .form-group select {
            width: 100%; padding: 12px 14px 12px 42px;
            border: 1.5px solid #d1fae5; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: var(--ink); background: white; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none; cursor: pointer;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px var(--teal-glow);
        }

        .field-error { color: var(--error); font-size: 12px; margin-top: 5px; }

        .btn-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--teal-dark), var(--teal));
            color: white; border: none; border-radius: 10px;
            font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all 0.2s; margin-top: 6px;
            box-shadow: 0 4px 14px rgba(13,124,102,0.3);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(13,124,102,0.4);
        }

        .terms-note {
            text-align: center; font-size: 12px;
            color: var(--ink-lite); margin-top: 14px; line-height: 1.6;
        }

        .terms-note a { color: var(--teal); text-decoration: none; font-weight: 500; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel { width: 100%; padding: 32px 24px; min-height: 180px; }
            .steps { display: none; }
            .right-panel { padding: 32px 24px; }
            .form-row-2 { grid-template-columns: 1fr; }
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
                Join the future of <em>smarter</em> healthcare.
            </h2>
            <p class="panel-desc">
                Create your account and get access to the tools your role needs — whether you're a doctor, patient, or administrator.
            </p>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">
                        <strong>Create your account</strong>
                        <span>Fill in your details and choose your role</span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">
                        <strong>Access your dashboard</strong>
                        <span>Your role determines what you see and manage</span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">
                        <strong>Start delivering care</strong>
                        <span>Book appointments, consult, prescribe and bill</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer">© 2026 MediConnect. All rights reserved.</div>
    </div>

    <div class="right-panel">
        <div class="form-box">

            <div class="form-header">
                <h2>Create your account</h2>
                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </div>

            @if ($errors->any())
                <div class="error-bag">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon">👤</span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Chukwuemeka Okafor" autocomplete="name" required />
                    </div>
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">✉️</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@hospital.com" autocomplete="email" required />
                    </div>
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="role">Your Role</label>
                    <div class="input-wrap">
                        <span class="input-icon">🏷️</span>
                        <select id="role" name="role">
                            <option value="patient"  {{ old('role')=='patient'  ? 'selected':'' }}>Patient</option>
                            <option value="doctor"   {{ old('role')=='doctor'   ? 'selected':'' }}>Doctor</option>
                            <option value="nurse"    {{ old('role')=='nurse'    ? 'selected':'' }}>Nurse</option>
                            <option value="lab"      {{ old('role')=='lab'      ? 'selected':'' }}>Lab Staff</option>
                            <option value="billing"  {{ old('role')=='billing'  ? 'selected':'' }}>Billing Officer</option>
                            <option value="admin"    {{ old('role')=='admin'    ? 'selected':'' }}>Admin</option>
                        </select>
                    </div>
                    @error('role')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">🔒</span>
                            <input type="password" id="password" name="password" placeholder="Min. 8 characters" autocomplete="new-password" required />
                        </div>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm</label>
                        <div class="input-wrap">
                            <span class="input-icon">🔒</span>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" autocomplete="new-password" required />
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Create Account</button>
            </form>

            <p class="terms-note">
                By registering, you agree to MediConnect's
                <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </p>

        </div>
    </div>

</body>
</html>