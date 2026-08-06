<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Patient Profile</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-dark: #064e3b; --teal: #0d7c66; --teal-mid: #14a085;
            --teal-lite: #ecfdf5; --white: #ffffff; --ink: #0f1f1b;
            --ink-mid: #374151; --ink-lite: #6b7280; --border: #d1fae5;
            --cream: #f0fdf8;
        }

        body { font-family: 'Inter', sans-serif; background: var(--cream); color: var(--ink); min-height: 100vh; }

        .topbar { height: 62px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 28px; gap: 16px; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-brand { display: flex; align-items: center; gap: 10px; flex: 1; }
        .topbar-brand .icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .topbar-brand h1 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--teal-dark); }
        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-mid); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; }

        .layout { display: flex; }

        .sidebar { width: 240px; background: var(--white); border-right: 1px solid var(--border); padding: 20px 0; position: sticky; top: 62px; height: calc(100vh - 62px); overflow-y: auto; display: flex; flex-direction: column; }
        .nav-section { padding: 16px 20px 6px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ink-lite); }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: var(--ink-mid); font-size: 14px; border-left: 3px solid transparent; transition: all 0.15s; font-weight: 500; text-decoration: none; }
        .nav-item:hover { background: var(--teal-lite); color: var(--teal); }
        .nav-item.active { background: var(--teal-lite); color: var(--teal); border-left-color: var(--teal); font-weight: 600; }
        .nav-icon { font-size: 16px; width: 22px; text-align: center; }
        .nav-badge { margin-left: auto; background: var(--teal); color: white; border-radius: 20px; font-size: 10px; padding: 2px 8px; font-weight: 700; }
        .nav-badge.red { background: #ef4444; }
        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid var(--border); font-size: 12px; color: var(--ink-lite); }

        .main { flex: 1; padding: 28px 32px; }

        .breadcrumb { display: flex; gap: 8px; align-items: center; font-size: 13px; color: var(--ink-lite); margin-bottom: 20px; }
        .breadcrumb a { color: var(--teal); text-decoration: none; font-weight: 500; }

        .profile-header { background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 12px; padding: 28px 32px; display: flex; align-items: center; gap: 24px; margin-bottom: 24px; }
        .profile-avatar { width: 72px; height: 72px; border-radius: 50%; background: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.4); color: white; font-weight: 800; font-size: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .profile-info h2 { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: white; margin-bottom: 6px; }
        .profile-meta { display: flex; gap: 16px; flex-wrap: wrap; }
        .profile-meta span { font-size: 13px; color: rgba(255,255,255,0.75); display: flex; align-items: center; gap: 5px; }
        .profile-actions { margin-left: auto; display: flex; gap: 10px; }

        .btn { padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-white { background: white; color: var(--teal); }
        .btn-white:hover { background: var(--teal-lite); }
        .btn-danger { background: #fee2e2; color: #991b1b; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); margin-bottom: 20px; }
        .card h3 { font-size: 14px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border); }

        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--ink-lite); font-weight: 500; }
        .info-value { color: var(--ink); font-weight: 600; text-align: right; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green { background: #d1fae5; color: #065f46; }
        .pill-blue  { background: #dbeafe; color: #1e40af; }
        .pill-red   { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

<header class="topbar">
    <div class="topbar-brand">
        <div class="icon">🏥</div>
        <h1>MediConnect</h1>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Sign Out</button>
    </form>
</header>

<div class="layout">

    @include('partials.sidebar')

    <main class="main">

        <div class="breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span>›</span>
            <span>{{ $patient->full_name }}</span>
        </div>

        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($patient->first_name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h2>{{ $patient->full_name }}</h2>
                <div class="profile-meta">
                    <span>🎂 {{ $patient->age }} years old</span>
                    <span>⚧ {{ $patient->gender }}</span>
                    <span>📞 {{ $patient->phone }}</span>
                    <span>🩸 {{ $patient->blood_group }}</span>
                    <span>
                        <span class="pill {{ $patient->status === 'active' ? 'pill-green' : 'pill-red' }}">
                            {{ ucfirst($patient->status) }}
                        </span>
                    </span>
                </div>
            </div>
            <div class="profile-actions">
                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-white">✏️ Edit</a>
                <form method="POST" action="{{ route('patients.destroy', $patient) }}" onsubmit="return confirm('Remove this patient?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">🗑 Delete</button>
                </form>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <h3>Personal Information</h3>
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $patient->full_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date of Birth</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Age</span>
                    <span class="info-value">{{ $patient->age }} years</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Gender</span>
                    <span class="info-value">{{ $patient->gender }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $patient->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">State of Origin</span>
                    <span class="info-value">{{ $patient->state_of_origin ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address</span>
                    <span class="info-value">{{ $patient->address ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Registered</span>
                    <span class="info-value">{{ $patient->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="card">
                <h3>Medical Information</h3>
                <div class="info-row">
                    <span class="info-label">Blood Group</span>
                    <span class="info-value"><span class="pill pill-blue">{{ $patient->blood_group }}</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Genotype</span>
                    <span class="info-value">{{ $patient->genotype ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Known Allergies</span>
                    <span class="info-value">{{ $patient->allergies ?? 'None' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="pill {{ $patient->status === 'active' ? 'pill-green' : 'pill-red' }}">
                            {{ ucfirst($patient->status) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

    </main>
</div>

</body>
</html>