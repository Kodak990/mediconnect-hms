<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Lab Results</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-dark: #064e3b; --teal: #0d7c66; --teal-mid: #14a085;
            --teal-lite: #ecfdf5; --teal-glow: rgba(13,124,102,0.15);
            --white: #ffffff; --ink: #0f1f1b; --ink-mid: #374151;
            --ink-lite: #6b7280; --border: #d1fae5; --cream: #f0fdf8;
            --error: #dc2626; --error-bg: #fef2f2;
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
        .btn-primary { background: var(--teal); color: white; box-shadow: 0 2px 8px rgba(13,124,102,0.25); }
        .btn-primary:hover { background: var(--teal-mid); }
        .btn-ghost { background: var(--white); color: var(--ink-mid); border: 1.5px solid var(--border); }
        .btn-ghost:hover { background: var(--cream); }

        .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-mini { background: var(--white); border-radius: 10px; padding: 16px 20px; border: 1px solid var(--border); position: relative; overflow: hidden; }
        .stat-mini::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); }
        .stat-mini.warn::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-mini.blue::before { background: linear-gradient(90deg, #1d4ed8, #3b82f6); }
        .stat-mini.danger::before { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .stat-mini .num { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--ink); }
        .stat-mini .lbl { font-size: 12px; color: var(--ink-lite); margin-top: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); margin-bottom: 20px; }

        .filter-bar { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-bar input, .filter-bar select { padding: 9px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; color: var(--ink); }
        .filter-bar input { flex: 1; min-width: 200px; }
        .filter-bar input:focus, .filter-bar select:focus { border-color: var(--teal); }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { background: var(--teal-lite); color: var(--teal); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--ink-mid); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf8; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-red    { background: #fee2e2; color: #991b1b; }
        .pill-gray   { background: #f3f4f6; color: #4b5563; }

        .action-btn { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; margin-right: 4px; transition: all 0.2s; }
        .action-review { background: #d1fae5; color: #065f46; }
        .action-flag   { background: #fee2e2; color: #991b1b; }
        .action-del    { background: #f3f4f6; color: #4b5563; }

        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #065f46; font-size: 14px; font-weight: 500; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 14px; padding: 28px; max-width: 540px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); max-height: 90vh; overflow-y: auto; }
        .modal h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 18px; color: var(--ink); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 13px; font-weight: 600; color: var(--ink-mid); }
        input, select, textarea { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s; }
        input:focus, select:focus, textarea:focus { border-color: var(--teal); }
        textarea { resize: vertical; min-height: 70px; }

        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); }

        .error-bag { background: var(--error-bg); border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }

        .abnormal-row td { background: #fff5f5 !important; }
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
                <h2>Laboratory Results</h2>
                <p>Upload, track, and manage all patient test results.</p>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('modal-lab').classList.add('open')">
                + Upload Result
            </button>
        </div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-bag">
                @foreach($errors->all() as $error)<p>⚠ {{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="stat-row">
            <div class="stat-mini">
                <div class="num">{{ $totalTests }}</div>
                <div class="lbl">Total Tests</div>
            </div>
            <div class="stat-mini warn">
                <div class="num" style="color:#92400e;">{{ $pendingTests }}</div>
                <div class="lbl">Pending</div>
            </div>
            <div class="stat-mini blue">
                <div class="num" style="color:#1e40af;">{{ $completedTests }}</div>
                <div class="lbl">Completed</div>
            </div>
            <div class="stat-mini danger">
                <div class="num" style="color:#991b1b;">{{ $abnormalTests }}</div>
                <div class="lbl">Abnormal</div>
            </div>
        </div>

        <div class="card">
            <form class="filter-bar" method="GET" action="{{ route('lab-results.index') }}">
                <input type="text" name="search" placeholder="🔍  Search patient, test, or doctor…" value="{{ $search ?? '' }}"/>
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="pending"   {{ ($status??'')==='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="completed" {{ ($status??'')==='completed' ? 'selected':'' }}>Completed</option>
                    <option value="abnormal"  {{ ($status??'')==='abnormal'  ? 'selected':'' }}>Abnormal</option>
                    <option value="reviewed"  {{ ($status??'')==='reviewed'  ? 'selected':'' }}>Reviewed</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('lab-results.index') }}" class="btn" style="background:#f3f4f6;color:var(--ink-mid);">Clear</a>
            </form>

            @if($results->count())
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Test</th>
                            <th>Result</th>
                            <th>Reference</th>
                            <th>Requested By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr class="{{ $result->status === 'abnormal' ? 'abnormal-row' : '' }}">
                            <td><strong>{{ $result->id }}</strong></td>
                            <td><strong>{{ $result->patient->full_name }}</strong></td>
                            <td>{{ $result->test_name }}</td>
                            <td>
                                {{ $result->result ?? '—' }}
                                @if($result->status === 'abnormal')
                                    <span style="color:#991b1b;font-size:11px;font-weight:700;"> ⚠ ABNORMAL</span>
                                @endif
                            </td>
                            <td>{{ $result->reference_range ?? '—' }}</td>
                            <td>{{ $result->requested_by }}</td>
                            <td>{{ \Carbon\Carbon::parse($result->test_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="pill
                                    {{ $result->status === 'pending'   ? 'pill-orange' : '' }}
                                    {{ $result->status === 'completed' ? 'pill-green'  : '' }}
                                    {{ $result->status === 'abnormal'  ? 'pill-red'    : '' }}
                                    {{ $result->status === 'reviewed'  ? 'pill-blue'   : '' }}">
                                    {{ ucfirst($result->status) }}
                                </span>
                            </td>
                            <td>
                                @if($result->status === 'pending')
                                    <form method="POST" action="{{ route('lab-results.update', $result) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="completed"/>
                                        <button type="submit" class="action-btn action-review">Complete</button>
                                    </form>
                                    <form method="POST" action="{{ route('lab-results.update', $result) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="abnormal"/>
                                        <button type="submit" class="action-btn action-flag">Flag</button>
                                    </form>
                                @elseif($result->status === 'abnormal')
                                    <form method="POST" action="{{ route('lab-results.update', $result) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="reviewed"/>
                                        <button type="submit" class="action-btn action-review">Mark Reviewed</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('lab-results.destroy', $result) }}" style="display:inline;" onsubmit="return confirm('Delete this result?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn action-del">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:20px;">
                    {{ $results->links() }}
                </div>

            @else
                <div class="empty-state">
                    <div class="icon">🔬</div>
                    <p>No lab results found.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<!-- UPLOAD LAB RESULT MODAL -->
<div class="modal-overlay" id="modal-lab">
    <div class="modal">
        <h3>🔬 Upload Lab Result</h3>
        <form method="POST" action="{{ route('lab-results.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group full">
                    <label>Patient *</label>
                    <select name="patient_id" required>
                        <option value="">Select patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group full">
                    <label>Test Name *</label>
                    <select name="test_name" required>
                        <option value="">Select test</option>
                        <option value="Full Blood Count (FBC)">Full Blood Count (FBC)</option>
                        <option value="Malaria Parasite">Malaria Parasite</option>
                        <option value="Hepatitis B Surface Antigen">Hepatitis B Surface Antigen</option>
                        <option value="Random Blood Sugar">Random Blood Sugar</option>
                        <option value="Fasting Blood Sugar">Fasting Blood Sugar</option>
                        <option value="HbA1c">HbA1c</option>
                        <option value="Urinalysis">Urinalysis</option>
                        <option value="Widal Test">Widal Test</option>
                        <option value="HIV Screening">HIV Screening</option>
                        <option value="Lipid Profile">Lipid Profile</option>
                        <option value="Liver Function Test">Liver Function Test</option>
                        <option value="Kidney Function Test">Kidney Function Test</option>
                        <option value="Thyroid Function Test">Thyroid Function Test</option>
                        <option value="Pregnancy Test (HCG)">Pregnancy Test (HCG)</option>
                        <option value="COVID-19 PCR">COVID-19 PCR</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Requested By *</label>
                    <select name="requested_by" required>
                        <option value="">Select doctor</option>
                        <option value="Dr. Adaeze Okonkwo">Dr. Adaeze Okonkwo</option>
                        <option value="Dr. Emeka Nwosu">Dr. Emeka Nwosu</option>
                        <option value="Dr. Ngozi Eze">Dr. Ngozi Eze</option>
                        <option value="Dr. Tunde Bakare">Dr. Tunde Bakare</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Test Date *</label>
                    <input type="date" name="test_date" required value="{{ date('Y-m-d') }}"/>
                </div>
                <div class="form-group">
                    <label>Result</label>
                    <input type="text" name="result" placeholder="e.g. Negative / 5.2 mmol/L"/>
                </div>
                <div class="form-group">
                    <label>Reference Range</label>
                    <input type="text" name="reference_range" placeholder="e.g. 4.0 – 6.0 mmol/L"/>
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="abnormal">Abnormal</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Remarks / Notes</label>
                    <textarea name="remarks" placeholder="Pathologist notes or observations…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-lab').classList.remove('open')">Close</button>
                <button type="submit" class="btn btn-primary">Upload Result</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('modal-lab').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>

</body>
</html>