<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — My Dashboard</title>
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

        /* TOP NAV */
        .portal-topbar { height: 64px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 28px; gap: 24px; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.05); }
        .portal-brand { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .brand-icon { width: 34px; height: 34px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .brand-name { font-family: 'Playfair Display', serif; font-size: 1.15rem; color: var(--teal-dark); font-weight: 700; }
        .brand-tag { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--teal); background: var(--teal-lite); padding: 2px 8px; border-radius: 20px; }

        .portal-nav { display: flex; align-items: center; gap: 4px; flex: 1; justify-content: center; }
        .nav-link { display: flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; color: var(--ink-mid); text-decoration: none; transition: all 0.15s; white-space: nowrap; }
        .nav-link:hover { background: var(--teal-lite); color: var(--teal); }
        .nav-link.active { background: var(--teal-lite); color: var(--teal); font-weight: 700; }

        .portal-user { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
        .user-name { font-size: 13px; font-weight: 600; color: var(--ink-mid); }
        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-mid); padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; }

        /* MAIN */
        .main { max-width: 1000px; margin: 0 auto; padding: 32px 24px; }

        /* HERO */
        .hero { background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 16px; padding: 32px 36px; color: white; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; }
        .hero-left h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 6px; }
        .hero-left p { font-size: 14px; opacity: 0.75; }
        .hero-avatar { width: 70px; height: 70px; border-radius: 50%; background: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.35); color: white; font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; display: flex; align-items: center; justify-content: center; }

        /* STAT CARDS */
        .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--white); border-radius: 12px; padding: 20px 22px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); position: relative; overflow: hidden; text-decoration: none; display: block; transition: transform 0.15s, box-shadow 0.15s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); }
        .stat-card.warn::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-card.danger::before { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .stat-icon { font-size: 24px; margin-bottom: 10px; }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; }
        .stat-label { font-size: 12px; color: var(--ink-lite); margin-top: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        /* UPCOMING APPOINTMENTS */
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .section-header h3 { font-family: 'Playfair Display', serif; font-size: 1.15rem; color: var(--ink); }
        .section-header a { font-size: 13px; color: var(--teal); font-weight: 600; text-decoration: none; }
        .section-header a:hover { text-decoration: underline; }

        .appt-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
        .appt-card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; }
        .appt-date { background: var(--teal-lite); border-radius: 8px; padding: 8px 12px; text-align: center; flex-shrink: 0; }
        .appt-date .day { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: var(--teal); line-height: 1; }
        .appt-date .mon { font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--teal); letter-spacing: 0.5px; }
        .appt-body { flex: 1; }
        .appt-body strong { font-size: 14px; color: var(--ink); display: block; margin-bottom: 3px; }
        .appt-body span { font-size: 12px; color: var(--ink-lite); }
        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }

        .empty-box { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 32px; text-align: center; color: var(--ink-lite); }
        .empty-box .icon { font-size: 36px; margin-bottom: 8px; }
        .empty-box p { font-size: 14px; }

        /* INFO CARD */
        .info-card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
        .info-card h3 { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--ink); margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid var(--border); }
        .info-row { display: flex; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid var(--border); font-size: 13.5px; }
        .info-row:last-child { border-bottom: none; }
        .info-row span { color: var(--ink-lite); }
        .info-row strong { color: var(--ink); }
    </style>
</head>
<body>

@include('partials.patient-nav')

<div class="main">

    <div class="hero">
        <div class="hero-left">
            <h2>Welcome back, {{ $patient->first_name }}!</h2>
            <p>Here's a summary of your health records at MediConnect.</p>
        </div>
        <div class="hero-avatar">{{ strtoupper(substr($patient->first_name, 0, 1)) }}</div>
    </div>

    <div class="stat-row">
        <a href="{{ route('patient.appointments') }}" class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-num">{{ $totalAppointments }}</div>
            <div class="stat-label">Total Appointments</div>
        </a>
        <a href="{{ route('patient.prescriptions') }}" class="stat-card warn">
            <div class="stat-icon">💊</div>
            <div class="stat-num">{{ $activePrescriptions }}</div>
            <div class="stat-label">Active Prescriptions</div>
        </a>
        <a href="{{ route('patient.bills') }}" class="stat-card danger">
            <div class="stat-icon">💳</div>
            <div class="stat-num">{{ $pendingBills }}</div>
            <div class="stat-label">Pending Bills</div>
        </a>
    </div>

    <div class="section-header">
        <h3>📅 Upcoming Appointments</h3>
        <a href="{{ route('patient.appointments') }}">View all →</a>
    </div>

    @if($upcomingAppointments->count())
        <div class="appt-list">
            @foreach($upcomingAppointments as $appt)
            <div class="appt-card">
                <div class="appt-date">
                    <div class="day">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d') }}</div>
                    <div class="mon">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M') }}</div>
                </div>
                <div class="appt-body">
                    <strong>{{ $appt->doctor_name }} — {{ $appt->department }}</strong>
                    <span>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('l') }} at {{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</span>
                </div>
                <span class="pill {{ $appt->status === 'confirmed' ? 'pill-green' : ($appt->type === 'telemedicine' ? 'pill-blue' : 'pill-orange') }}">
                    {{ ucfirst($appt->status) }}
                </span>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-box" style="margin-bottom:28px;">
            <div class="icon">📅</div>
            <p>No upcoming appointments. Contact the hospital to book one.</p>
        </div>
    @endif

    <div class="info-card">
        <h3>👤 Your Details</h3>
        <div class="info-row"><span>Full Name</span><strong>{{ $patient->full_name }}</strong></div>
        <div class="info-row"><span>Date of Birth</span><strong>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</strong></div>
        <div class="info-row"><span>Age</span><strong>{{ $patient->age }} years</strong></div>
        <div class="info-row"><span>Gender</span><strong>{{ $patient->gender }}</strong></div>
        <div class="info-row"><span>Blood Group</span><strong>{{ $patient->blood_group }}</strong></div>
        <div class="info-row"><span>Genotype</span><strong>{{ $patient->genotype ?? '—' }}</strong></div>
        <div class="info-row"><span>Known Allergies</span><strong>{{ $patient->allergies ?? 'None' }}</strong></div>
        <div class="info-row"><span>Phone</span><strong>{{ $patient->phone }}</strong></div>
    </div>

</div>

</body>
</html>