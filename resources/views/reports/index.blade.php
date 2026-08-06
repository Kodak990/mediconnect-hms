<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Reports</title>
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
        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-mid); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; }
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

        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-header h2 { font-family: 'Playfair Display', serif; font-size: 1.65rem; color: var(--ink); }
        .page-header p { color: var(--ink-lite); font-size: 14px; margin-top: 3px; }

        .btn { padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--teal); color: white; }
        .btn-primary:hover { background: var(--teal-mid); }
        .btn-ghost { background: var(--white); color: var(--ink-mid); border: 1.5px solid var(--border); }
        .btn-ghost:hover { background: var(--cream); }

        .stat-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }

        .stat-card { background: var(--white); border-radius: 12px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); }
        .stat-card.blue::before   { background: linear-gradient(90deg, #1d4ed8, #3b82f6); }
        .stat-card.green::before  { background: linear-gradient(90deg, #065f46, #10b981); }
        .stat-card.orange::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-card.red::before    { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .stat-card.purple::before { background: linear-gradient(90deg, #6d28d9, #8b5cf6); }

        .stat-label { font-size: 11px; font-weight: 700; color: var(--ink-lite); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; }
        .stat-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; margin-bottom: 6px; }
        .stat-sub { font-size: 12px; color: #065f46; font-weight: 500; }
        .stat-sub.warn { color: #92400e; }
        .stat-sub.danger { color: #991b1b; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .grid-3c { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 20px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
        .card h3 { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }

        .chart-wrap { display: flex; align-items: flex-end; gap: 10px; height: 140px; margin-top: 8px; }
        .bar-col { display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1; }
        .bar { width: 100%; border-radius: 6px 6px 0 0; background: linear-gradient(180deg, var(--teal-mid), var(--teal-dark)); transition: opacity 0.2s; min-height: 4px; }
        .bar:hover { opacity: 0.75; }
        .bar-val { font-size: 10px; color: var(--teal); font-weight: 700; }
        .bar-label { font-size: 10px; color: var(--ink-lite); font-weight: 500; }

        .progress-item { margin-bottom: 14px; }
        .progress-label { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px; }
        .progress-label span { color: var(--ink-mid); font-weight: 500; }
        .progress-label strong { color: var(--ink); }
        .progress-track { background: var(--teal-lite); border-radius: 20px; height: 8px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 20px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); transition: width 0.6s ease; }
        .progress-fill.blue   { background: linear-gradient(90deg, #1d4ed8, #3b82f6); }
        .progress-fill.orange { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .progress-fill.red    { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .progress-fill.purple { background: linear-gradient(90deg, #6d28d9, #8b5cf6); }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { background: var(--teal-lite); color: var(--teal); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; }
        td { padding: 11px 14px; border-bottom: 1px solid var(--border); color: var(--ink-mid); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf8; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-red    { background: #fee2e2; color: #991b1b; }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; color: var(--ink);
            margin: 28px 0 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--border);
            display: flex; align-items: center; gap: 8px;
        }

        .summary-box {
            background: linear-gradient(135deg, var(--teal-dark), var(--teal));
            border-radius: 12px; padding: 24px 28px;
            color: white; margin-bottom: 20px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .summary-box h3 { font-family: 'Playfair Display', serif; font-size: 1.1rem; opacity: 0.85; margin-bottom: 6px; }
        .summary-box .big { font-family: 'Playfair Display', serif; font-size: 2.6rem; font-weight: 700; line-height: 1; }
        .summary-box .sub { font-size: 13px; opacity: 0.7; margin-top: 4px; }
        .summary-divider { width: 1px; background: rgba(255,255,255,0.2); height: 60px; }

        @media (max-width: 1024px) { .stat-grid-4, .stat-grid-3 { grid-template-columns: repeat(2, 1fr); } .grid-2, .grid-3c { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .sidebar { display: none; } .main { padding: 18px 16px; } }
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

        <div class="page-header">
            <div>
                <h2>Reports & Analytics</h2>
                <p>Full overview of hospital performance and statistics.</p>
            </div>
            <div style="display:flex;gap:10px;">
                <button class="btn btn-ghost" onclick="window.print()">🖨️ Print Report</button>
            </div>
        </div>

        <div class="summary-box">
            <div>
                <h3>Total Registered Patients</h3>
                <div class="big">{{ $totalPatients }}</div>
                <div class="sub">{{ $activePatients }} active patients</div>
            </div>
            <div class="summary-divider"></div>
            <div>
                <h3>Total Revenue Collected</h3>
                <div class="big">${{ number_format($totalRevenue, 0) }}</div>
                <div class="sub">From {{ $paidInvoices }} paid invoices</div>
            </div>
            <div class="summary-divider"></div>
            <div>
                <h3>Total Appointments</h3>
                <div class="big">{{ $totalAppointments }}</div>
                <div class="sub">{{ $completedAppointments }} completed</div>
            </div>
            <div class="summary-divider"></div>
            <div>
                <h3>Staff Members</h3>
                <div class="big">{{ $totalUsers }}</div>
                <div class="sub">{{ $totalDoctors }} doctors, {{ $totalNurses }} nurses</div>
            </div>
        </div>

        <div class="section-title">👥 Patients & Appointments</div>
        <div class="stat-grid-4">
            <div class="stat-card">
                <div class="stat-label">Total Patients</div>
                <div class="stat-value">{{ $totalPatients }}</div>
                <div class="stat-sub">{{ $activePatients }} active</div>
            </div>
            <div class="stat-card blue">
                <div class="stat-label">Total Appointments</div>
                <div class="stat-value">{{ $totalAppointments }}</div>
                <div class="stat-sub">{{ $pendingAppointments }} pending</div>
            </div>
            <div class="stat-card green">
                <div class="stat-label">Telemedicine</div>
                <div class="stat-value">{{ $telemedicineCount }}</div>
                <div class="stat-sub">
                    {{ $totalAppointments > 0 ? round(($telemedicineCount / $totalAppointments) * 100) : 0 }}% of all appointments
                </div>
            </div>
            <div class="stat-card orange">
                <div class="stat-label">Physical Visits</div>
                <div class="stat-value">{{ $physicalCount }}</div>
                <div class="stat-sub">
                    {{ $totalAppointments > 0 ? round(($physicalCount / $totalAppointments) * 100) : 0 }}% of all appointments
                </div>
            </div>
        </div>

        <div class="grid-3c">
            <div class="card">
                <h3>📊 Monthly Appointments (Last 6 Months)</h3>
                @php $maxCount = max(array_column($monthlyData, 'count') ?: [1]); @endphp
                <div class="chart-wrap">
                    @foreach($monthlyData as $m)
                    @php $height = $maxCount > 0 ? max(4, round(($m['count'] / $maxCount) * 130)) : 4; @endphp
                    <div class="bar-col">
                        <span class="bar-val">{{ $m['count'] }}</span>
                        <div class="bar" style="height:{{ $height }}px"></div>
                        <span class="bar-label">{{ $m['month'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <h3>📋 Appointment Status</h3>
                @php
                    $statuses = [
                        ['label' => 'Completed', 'count' => $completedAppointments, 'class' => ''],
                        ['label' => 'Pending',   'count' => $pendingAppointments,   'class' => 'orange'],
                        ['label' => 'Cancelled', 'count' => \App\Models\Appointment::where('status','cancelled')->count(), 'class' => 'red'],
                        ['label' => 'Confirmed', 'count' => \App\Models\Appointment::where('status','confirmed')->count(), 'class' => 'blue'],
                    ];
                    $maxStat = max(array_column($statuses, 'count') ?: [1]);
                @endphp
                @foreach($statuses as $s)
                <div class="progress-item">
                    <div class="progress-label">
                        <span>{{ $s['label'] }}</span>
                        <strong>{{ $s['count'] }}</strong>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill {{ $s['class'] }}" style="width:{{ $maxStat > 0 ? round(($s['count']/$maxStat)*100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-title">💰 Billing & Revenue</div>
        <div class="stat-grid-4">
            <div class="stat-card green">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">${{ number_format($totalRevenue, 0) }}</div>
                <div class="stat-sub">All time collected</div>
            </div>
            <div class="stat-card orange">
                <div class="stat-label">Outstanding</div>
                <div class="stat-value">${{ number_format($pendingRevenue, 0) }}</div>
                <div class="stat-sub warn">Pending payment</div>
            </div>
            <div class="stat-card blue">
                <div class="stat-label">Paid Invoices</div>
                <div class="stat-value">{{ $paidInvoices }}</div>
                <div class="stat-sub">Out of {{ $totalInvoices }} total</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Collection Rate</div>
                <div class="stat-value">{{ $totalInvoices > 0 ? round(($paidInvoices / $totalInvoices) * 100) : 0 }}%</div>
                <div class="stat-sub">Payment success rate</div>
            </div>
        </div>

        @if($revenueByService->count())
        <div class="card" style="margin-bottom:20px;">
            <h3>💳 Revenue by Service</h3>
            <table>
                <thead>
                    <tr><th>Service</th><th>Revenue</th><th>Share</th></tr>
                </thead>
                <tbody>
                    @foreach($revenueByService as $item)
                    <tr>
                        <td><strong>{{ $item->service }}</strong></td>
                        <td>${{ number_format($item->total, 2) }}</td>
                        <td>
                            @php $share = $totalRevenue > 0 ? round(($item->total / $totalRevenue) * 100) : 0; @endphp
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;background:var(--teal-lite);border-radius:20px;height:6px;overflow:hidden;">
                                    <div style="width:{{ $share }}%;height:100%;background:var(--teal);border-radius:20px;"></div>
                                </div>
                                <span style="font-size:12px;font-weight:600;color:var(--teal);min-width:30px;">{{ $share }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="section-title">🏥 Clinical Overview</div>
        <div class="grid-2">
            <div class="card">
                <h3>💊 Prescriptions</h3>
                @php
                    $prescStats = [
                        ['label' => 'Active',    'count' => $activePrescriptions,    'class' => ''],
                        ['label' => 'Dispensed', 'count' => $dispensedPrescriptions, 'class' => 'blue'],
                        ['label' => 'Cancelled', 'count' => \App\Models\Prescription::where('status','cancelled')->count(), 'class' => 'red'],
                    ];
                    $maxPresc = max(array_column($prescStats, 'count') ?: [1]);
                @endphp
                <div style="margin-bottom:12px;">
                    <span style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;">{{ $totalPrescriptions }}</span>
                    <span style="font-size:13px;color:var(--ink-lite);margin-left:8px;">total prescriptions</span>
                </div>
                @foreach($prescStats as $s)
                <div class="progress-item">
                    <div class="progress-label">
                        <span>{{ $s['label'] }}</span>
                        <strong>{{ $s['count'] }}</strong>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill {{ $s['class'] }}" style="width:{{ $maxPresc > 0 ? round(($s['count']/$maxPresc)*100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="card">
                <h3>🔬 Lab Results</h3>
                @php
                    $labStats = [
                        ['label' => 'Completed', 'count' => $completedResults, 'class' => ''],
                        ['label' => 'Pending',   'count' => $pendingResults,   'class' => 'orange'],
                        ['label' => 'Abnormal',  'count' => $abnormalResults,  'class' => 'red'],
                        ['label' => 'Reviewed',  'count' => \App\Models\LabResult::where('status','reviewed')->count(), 'class' => 'blue'],
                    ];
                    $maxLab = max(array_column($labStats, 'count') ?: [1]);
                @endphp
                <div style="margin-bottom:12px;">
                    <span style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;">{{ $totalLabResults }}</span>
                    <span style="font-size:13px;color:var(--ink-lite);margin-left:8px;">total lab tests</span>
                    @if($abnormalResults > 0)
                        <span class="pill pill-red" style="margin-left:8px;">⚠ {{ $abnormalResults }} Abnormal</span>
                    @endif
                </div>
                @foreach($labStats as $s)
                <div class="progress-item">
                    <div class="progress-label">
                        <span>{{ $s['label'] }}</span>
                        <strong>{{ $s['count'] }}</strong>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill {{ $s['class'] }}" style="width:{{ $maxLab > 0 ? round(($s['count']/$maxLab)*100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-title">👤 Staff Summary</div>
        <div class="stat-grid-3">
            <div class="stat-card">
                <div class="stat-label">Total System Users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-sub">All roles combined</div>
            </div>
            <div class="stat-card green">
                <div class="stat-label">Doctors</div>
                <div class="stat-value">{{ $totalDoctors }}</div>
                <div class="stat-sub">Medical staff</div>
            </div>
            <div class="stat-card blue">
                <div class="stat-label">Nurses</div>
                <div class="stat-value">{{ $totalNurses }}</div>
                <div class="stat-sub">Nursing staff</div>
            </div>
        </div>

    </main>
</div>

</body>
</html>