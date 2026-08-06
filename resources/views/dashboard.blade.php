<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Admin Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-dark:  #064e3b; --teal: #0d7c66; --teal-mid: #14a085;
            --teal-lite:  #ecfdf5; --white: #ffffff; --ink: #0f1f1b;
            --ink-mid:    #374151; --ink-lite: #6b7280; --border: #d1fae5;
            --cream:      #f0fdf8; --ok: #065f46; --warn: #92400e;
            --danger:     #991b1b; --sidebar-w: 240px;
        }

        body { font-family: 'Inter', sans-serif; background: var(--cream); color: var(--ink); min-height: 100vh; display: flex; flex-direction: column; }

        .topbar { height: 62px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 28px; gap: 16px; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-brand { display: flex; align-items: center; gap: 10px; flex: 1; }
        .topbar-brand .icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .topbar-brand h1 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--teal-dark); font-weight: 700; }
        .topbar-brand span { font-size: 11px; color: var(--ink-lite); background: var(--teal-lite); padding: 2px 8px; border-radius: 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .clock { font-size: 12px; color: var(--ink-lite); font-weight: 500; }
        .notif-btn { width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid var(--border); background: var(--white); display: flex; align-items: center; justify-content: center; font-size: 16px; cursor: pointer; position: relative; transition: all 0.2s; }
        .notif-btn:hover { background: var(--teal-lite); border-color: var(--teal); }
        .notif-dot { position: absolute; top: 6px; right: 6px; width: 7px; height: 7px; background: #ef4444; border-radius: 50%; border: 1.5px solid white; }
        .user-pill { display: flex; align-items: center; gap: 10px; background: var(--teal-lite); border: 1.5px solid var(--border); border-radius: 30px; padding: 5px 14px 5px 5px; cursor: pointer; }
        .avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); color: white; font-weight: 700; font-size: 12px; display: flex; align-items: center; justify-content: center; }
        .user-pill span { font-size: 13px; font-weight: 600; color: var(--teal-dark); }
        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-mid); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; }

        .layout { display: flex; flex: 1; }

        .sidebar { width: var(--sidebar-w); background: var(--white); border-right: 1px solid var(--border); padding: 20px 0; position: sticky; top: 62px; height: calc(100vh - 62px); overflow-y: auto; display: flex; flex-direction: column; }
        .nav-section { padding: 16px 20px 6px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ink-lite); }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: var(--ink-mid); font-size: 14px; cursor: pointer; border-left: 3px solid transparent; transition: all 0.15s; font-weight: 500; text-decoration: none; }
        .nav-item:hover { background: var(--teal-lite); color: var(--teal); }
        .nav-item.active { background: var(--teal-lite); color: var(--teal); border-left-color: var(--teal); font-weight: 600; }
        .nav-icon { font-size: 16px; width: 22px; text-align: center; }
        .nav-badge { margin-left: auto; background: var(--teal); color: white; border-radius: 20px; font-size: 10px; padding: 2px 8px; font-weight: 700; }
        .nav-badge.red { background: #ef4444; }
        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid var(--border); font-size: 12px; color: var(--ink-lite); }

        .main { flex: 1; padding: 28px 32px; overflow-y: auto; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 28px; }
        .page-header h2 { font-family: 'Playfair Display', serif; font-size: 1.65rem; color: var(--ink); font-weight: 700; }
        .page-header p { color: var(--ink-lite); font-size: 14px; margin-top: 3px; }
        .header-actions { display: flex; gap: 10px; }

        .btn { padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--teal); color: white; box-shadow: 0 2px 8px rgba(13,124,102,0.25); }
        .btn-primary:hover { background: var(--teal-mid); }
        .btn-outline { background: white; color: var(--teal); border: 1.5px solid var(--border); }
        .btn-outline:hover { background: var(--teal-lite); border-color: var(--teal); }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--white); border-radius: 12px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); }
        .stat-card.warn::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-card.danger::before { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .stat-card.blue::before { background: linear-gradient(90deg, #1d4ed8, #3b82f6); }
        .stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .stat-label { font-size: 12px; font-weight: 600; color: var(--ink-lite); text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--teal-lite); display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .stat-icon.warn { background: #fffbeb; }
        .stat-icon.danger { background: #fef2f2; }
        .stat-icon.blue { background: #eff6ff; }
        .stat-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; margin-bottom: 6px; }
        .stat-sub { font-size: 12px; color: var(--ok); font-weight: 500; }
        .stat-sub.warn { color: var(--warn); }
        .stat-sub.danger { color: var(--danger); }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .grid-3 { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .card-header h3 { font-size: 15px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; }
        .card-link { font-size: 12px; color: var(--teal); font-weight: 600; text-decoration: none; cursor: pointer; }

        .tbl-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { background: var(--teal-lite); color: var(--teal); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--ink-mid); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf8; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-red    { background: #fee2e2; color: #991b1b; }

        .queue-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border); }
        .queue-item:last-child { border-bottom: none; }
        .q-num { width: 32px; height: 32px; border-radius: 50%; background: var(--teal-lite); color: var(--teal); font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .q-num.emerg { background: #fee2e2; color: #991b1b; }
        .q-info { flex: 1; }
        .q-name { font-weight: 600; font-size: 14px; color: var(--ink); }
        .q-detail { font-size: 12px; color: var(--ink-lite); margin-top: 2px; }

        .notif-item { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border); align-items: flex-start; }
        .notif-item:last-child { border-bottom: none; }
        .notif-icon { width: 34px; height: 34px; border-radius: 10px; background: var(--teal-lite); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
        .notif-text { flex: 1; }
        .notif-text p { font-size: 13.5px; color: var(--ink); line-height: 1.4; }
        .notif-text span { font-size: 11px; color: var(--ink-lite); margin-top: 3px; display: block; }

        .chart-bar-wrap { display: flex; align-items: flex-end; gap: 8px; height: 120px; margin-top: 10px; }
        .bar-col { display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1; }
        .bar { width: 100%; border-radius: 6px 6px 0 0; background: linear-gradient(180deg, var(--teal-mid), var(--teal-dark)); transition: opacity 0.2s; }
        .bar:hover { opacity: 0.8; }
        .bar.lite { background: linear-gradient(180deg, #6ee7b7, #34d399); }
        .bar-label { font-size: 10px; color: var(--ink-lite); font-weight: 500; }
        .bar-val { font-size: 10px; color: var(--teal); font-weight: 700; }

        .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .dot-green { background: #10b981; }
        .dot-orange { background: #f59e0b; }
        .dot-red { background: #ef4444; }

        @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } .grid-2, .grid-3 { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .sidebar { display: none; } .main { padding: 18px 16px; } }
    </style>
</head>
<body>

<header class="topbar">
    <div class="topbar-brand">
        <div class="icon">🏥</div>
        <h1>MediConnect</h1>
        <span>Admin</span>
    </div>
    <div class="topbar-right">
        <div class="clock" id="clock"></div>
        <div class="notif-btn">🔔<div class="notif-dot"></div></div>
        <div class="user-pill">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span>{{ auth()->user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Sign Out</button>
        </form>
    </div>
</header>

<div class="layout">

    @include('partials.sidebar')

    <main class="main">

        @if(session('error'))
            <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;margin-bottom:20px;color:#991b1b;font-size:14px;font-weight:500;">
                ⚠ {{ session('error') }}
            </div>
        @endif

        <div class="page-header">
            <div>
                <h2 id="greeting">Good morning 👋</h2>
                <p>Here's what's happening at the hospital today.</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-outline">📥 Export Report</button>
                <a href="{{ route('patients.create') }}" class="btn btn-primary">+ New Patient</a>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Patients</span>
                    <div class="stat-icon">👥</div>
                </div>
                <div class="stat-value">{{ \App\Models\Patient::count() }}</div>
                <div class="stat-sub">Total registered patients</div>
            </div>
            <div class="stat-card blue">
                <div class="stat-top">
                    <span class="stat-label">Appointments</span>
                    <div class="stat-icon blue">📅</div>
                </div>
                <div class="stat-value">{{ \App\Models\Appointment::count() }}</div>
                <div class="stat-sub">{{ \App\Models\Appointment::where('status','pending')->count() }} pending</div>
            </div>
            <div class="stat-card warn">
                <div class="stat-top">
                    <span class="stat-label">Revenue</span>
                    <div class="stat-icon warn">💰</div>
                </div>
                <div class="stat-value">${{ number_format(\App\Models\Invoice::where('status','paid')->sum('amount'), 0) }}</div>
                <div class="stat-sub warn">Total collected</div>
            </div>
            <div class="stat-card danger">
                <div class="stat-top">
                    <span class="stat-label">Pending Bills</span>
                    <div class="stat-icon danger">💳</div>
                </div>
                <div class="stat-value">{{ \App\Models\Invoice::where('status','pending')->count() }}</div>
                <div class="stat-sub danger">${{ number_format(\App\Models\Invoice::where('status','pending')->sum('amount'), 0) }} outstanding</div>
            </div>
        </div>

        <div class="grid-3">
            <div class="card">
                <div class="card-header">
                    <h3>📊 Monthly Consultations</h3>
                    <a href="{{ route('reports.index') }}" class="card-link">View report →</a>
                </div>
                <div class="chart-bar-wrap">
                    <div class="bar-col"><span class="bar-val">88</span><div class="bar lite" style="height:66px"></div><span class="bar-label">Jan</span></div>
                    <div class="bar-col"><span class="bar-val">104</span><div class="bar" style="height:78px"></div><span class="bar-label">Feb</span></div>
                    <div class="bar-col"><span class="bar-val">96</span><div class="bar lite" style="height:72px"></div><span class="bar-label">Mar</span></div>
                    <div class="bar-col"><span class="bar-val">118</span><div class="bar" style="height:88px"></div><span class="bar-label">Apr</span></div>
                    <div class="bar-col"><span class="bar-val">132</span><div class="bar lite" style="height:99px"></div><span class="bar-label">May</span></div>
                    <div class="bar-col"><span class="bar-val">127</span><div class="bar" style="height:95px"></div><span class="bar-label">Jun</span></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>🚶 Live Queue</h3>
                    <a href="{{ route('queue.index') }}" class="card-link">Manage →</a>
                </div>
                <div class="queue-item">
                    <div class="q-num">1</div>
                    <div class="q-info"><div class="q-name">Ngozi Uche</div><div class="q-detail">General Practice — Remote</div></div>
                    <span class="pill pill-blue">Remote</span>
                </div>
                <div class="queue-item">
                    <div class="q-num">2</div>
                    <div class="q-info"><div class="q-name">Haruna Abdullahi</div><div class="q-detail">Cardiology — Physical</div></div>
                    <span class="pill pill-green">Physical</span>
                </div>
                <div class="queue-item">
                    <div class="q-num emerg">E1</div>
                    <div class="q-info"><div class="q-name">Unknown (RTA)</div><div class="q-detail">Emergency Unit</div></div>
                    <span class="pill pill-red">Emergency</span>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="card-header">
                    <h3>📅 Today's Appointments</h3>
                    <a href="{{ route('appointments.index') }}" class="card-link">View all →</a>
                </div>
                <div class="tbl-wrap">
                    <table>
                        <thead>
                            <tr><th>Patient</th><th>Doctor</th><th>Time</th><th>Type</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Appointment::with('patient')->latest()->take(4)->get() as $appt)
                            <tr>
                                <td><strong>{{ $appt->patient->full_name }}</strong></td>
                                <td>{{ $appt->doctor_name }}</td>
                                <td>{{ $appt->formatted_time }}</td>
                                <td><span class="pill {{ $appt->type === 'telemedicine' ? 'pill-blue' : 'pill-green' }}">{{ ucfirst($appt->type) }}</span></td>
                                <td>
                                    <span class="pill
                                        {{ $appt->status === 'confirmed' ? 'pill-green' : '' }}
                                        {{ $appt->status === 'pending'   ? 'pill-orange' : '' }}
                                        {{ $appt->status === 'cancelled' ? 'pill-red' : '' }}
                                        {{ $appt->status === 'completed' ? 'pill-blue' : '' }}">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" style="text-align:center;color:var(--ink-lite);padding:20px;">No appointments yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>🔔 Notifications</h3>
                    <span class="card-link">Clear all</span>
                </div>
                <div class="notif-item">
                    <div class="notif-icon">📹</div>
                    <div class="notif-text"><p>Telemedicine session with <strong>Chioma Adeyemi</strong> starts in 15 minutes</p><span>10:15 AM</span></div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon">🔬</div>
                    <div class="notif-text"><p>Lab results for <strong>Emeka Obi</strong> flagged — HbA1c abnormal</p><span>09:42 AM</span></div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon">💳</div>
                    <div class="notif-text"><p>Invoice <strong>INV-003</strong> still pending — Aisha Mohammed</p><span>09:00 AM</span></div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon" style="background:#fee2e2;">🚨</div>
                    <div class="notif-text"><p>Emergency case admitted to queue — <strong>Unit A</strong></p><span>08:55 AM</span></div>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="card-header">
                    <h3>💰 Revenue</h3>
                    <a href="{{ route('billing.index') }}" class="card-link">View all →</a>
                </div>
                <div style="display:flex;align-items:center;gap:20px;">
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:2.4rem;font-weight:700;color:var(--ink);">
                            ${{ number_format(\App\Models\Invoice::where('status','paid')->sum('amount'), 0) }}
                        </div>
                        <div style="font-size:13px;color:var(--ok);font-weight:500;margin-top:4px;">Total revenue collected</div>
                    </div>
                    <div style="flex:1;border-left:1px solid var(--border);padding-left:20px;display:flex;flex-direction:column;gap:10px;">
                        <div style="display:flex;justify-content:space-between;font-size:13px;">
                            <span><span class="dot dot-green"></span>Paid Invoices</span>
                            <strong>{{ \App\Models\Invoice::where('status','paid')->count() }}</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;">
                            <span><span class="dot dot-orange"></span>Pending</span>
                            <strong>{{ \App\Models\Invoice::where('status','pending')->count() }}</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;">
                            <span><span class="dot dot-red"></span>Cancelled</span>
                            <strong>{{ \App\Models\Invoice::where('status','cancelled')->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>🏥 Department Status</h3>
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
                        <span><span class="dot dot-green"></span>General Practice</span>
                        <span style="color:var(--ink-lite);">12 patients</span>
                        <span class="pill pill-green">Normal</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
                        <span><span class="dot dot-orange"></span>Cardiology</span>
                        <span style="color:var(--ink-lite);">5 patients</span>
                        <span class="pill pill-orange">Busy</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
                        <span><span class="dot dot-green"></span>Paediatrics</span>
                        <span style="color:var(--ink-lite);">4 patients</span>
                        <span class="pill pill-green">Normal</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
                        <span><span class="dot dot-red"></span>Emergency</span>
                        <span style="color:var(--ink-lite);">3 patients</span>
                        <span class="pill pill-red">Critical</span>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent = now.toLocaleDateString('en-NG', {
            weekday: 'short', day: 'numeric', month: 'short', year: 'numeric'
        }) + '  ' + now.toLocaleTimeString('en-NG', {
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
    }
    updateClock();
    setInterval(updateClock, 1000);

    const h = new Date().getHours();
    const name = "{{ auth()->user()->name }}".split(' ')[0];
    document.getElementById('greeting').textContent =
        (h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening') + ', ' + name + ' 👋';
</script>

</body>
</html>