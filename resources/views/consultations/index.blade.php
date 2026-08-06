<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Consultations</title>
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
        .btn-sm { padding: 6px 12px; font-size: 12px; }

        .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-mini { background: var(--white); border-radius: 10px; padding: 16px 20px; border: 1px solid var(--border); position: relative; overflow: hidden; }
        .stat-mini::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); }
        .stat-mini.blue::before { background: linear-gradient(90deg, #1d4ed8, #3b82f6); }
        .stat-mini.warn::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-mini .num { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--ink); }
        .stat-mini .lbl { font-size: 12px; color: var(--ink-lite); margin-top: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); margin-bottom: 20px; }

        .consult-list { display: flex; flex-direction: column; gap: 14px; }

        .consult-card {
            background: var(--cream); border: 1.5px solid var(--border);
            border-radius: 10px; padding: 18px 20px; transition: all 0.2s;
        }

        .consult-card.active { border-color: var(--teal); background: var(--teal-lite); }

        .consult-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .consult-name { font-weight: 700; font-size: 15px; color: var(--ink); }
        .consult-meta { font-size: 12px; color: var(--ink-lite); margin-top: 3px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-gray   { background: #f3f4f6; color: #4b5563; }

        .vitals-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin: 12px 0; }
        .vital-box { background: var(--white); border: 1px solid var(--border); border-radius: 8px; padding: 8px 10px; text-align: center; }
        .vital-box .v-label { font-size: 10px; color: var(--ink-lite); text-transform: uppercase; font-weight: 600; }
        .vital-box .v-val { font-size: 14px; font-weight: 700; color: var(--ink); margin-top: 2px; }

        .clinical-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
        .clinical-field label { font-size: 12px; font-weight: 600; color: var(--ink-mid); display: block; margin-bottom: 4px; }
        .clinical-field textarea, .clinical-field input { width: 100%; padding: 8px 10px; border: 1.5px solid var(--border); border-radius: 6px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; }
        .clinical-field textarea:focus, .clinical-field input:focus { border-color: var(--teal); }
        .clinical-field textarea { resize: vertical; min-height: 60px; }

        .consult-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }

        .action-btn { padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
        .action-save     { background: var(--teal); color: white; }
        .action-complete { background: #d1fae5; color: #065f46; }
        .action-rx       { background: #dbeafe; color: #1e40af; }
        .action-lab      { background: #ede9fe; color: #5b21b6; }
        .action-del      { background: #fee2e2; color: #991b1b; }

        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #065f46; font-size: 14px; font-weight: 500; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 14px; padding: 28px; max-width: 480px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); max-height: 90vh; overflow-y: auto; }
        .modal h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 18px; color: var(--ink); }

        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
        label { font-size: 13px; font-weight: 600; color: var(--ink-mid); }
        select, input, textarea { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s; width: 100%; }
        select:focus, input:focus, textarea:focus { border-color: var(--teal); }
        textarea { resize: vertical; min-height: 70px; }

        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); }

        .error-bag { background: var(--error-bg); border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }
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

    <nav class="sidebar">
        <div class="nav-section">Overview</div>
        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-section">Patient Care</div>
        <a class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">
            <span class="nav-icon">👥</span> Patients
            <span class="nav-badge">{{ \App\Models\Patient::count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
            <span class="nav-icon">📅</span> Appointments
            <span class="nav-badge">{{ \App\Models\Appointment::where('status','pending')->count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('queue.*') ? 'active' : '' }}" href="{{ route('queue.index') }}">
            <span class="nav-icon">🚶</span> Queue
            <span class="nav-badge">{{ \App\Models\QueueEntry::whereDate('created_at', now())->whereIn('status',['waiting','in_progress'])->count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('telemedicine.*') ? 'active' : '' }}" href="{{ route('telemedicine.index') }}">
            <span class="nav-icon">📹</span> Telemedicine
            <span class="nav-badge">{{ \App\Models\TelemedicineSession::whereIn('status',['scheduled','in_progress'])->count() }}</span>
        </a>

        <div class="nav-section">Clinical</div>
        <a class="nav-item {{ request()->routeIs('consultations.*') ? 'active' : '' }}" href="{{ route('consultations.index') }}">
            <span class="nav-icon">📋</span> Consultations
            <span class="nav-badge">{{ \App\Models\Consultation::where('status','in_progress')->count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('prescriptions.*') ? 'active' : '' }}" href="{{ route('prescriptions.index') }}">
            <span class="nav-icon">💊</span> Prescriptions
            <span class="nav-badge">{{ \App\Models\Prescription::where('status','active')->count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('lab-results.*') ? 'active' : '' }}" href="{{ route('lab-results.index') }}">
            <span class="nav-icon">🔬</span> Lab Results
            <span class="nav-badge red">{{ \App\Models\LabResult::where('status','abnormal')->count() }}</span>
        </a>

        <div class="nav-section">Administration</div>
        <a class="nav-item {{ request()->routeIs('billing.*') ? 'active' : '' }}" href="{{ route('billing.index') }}">
            <span class="nav-icon">💳</span> Billing
            <span class="nav-badge red">{{ \App\Models\Invoice::where('status','pending')->count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <span class="nav-icon">👤</span> Users
            <span class="nav-badge">{{ \App\Models\User::count() }}</span>
        </a>
        <a class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
            <span class="nav-icon">📈</span> Reports
        </a>

        <div class="sidebar-footer">
            MediConnect v1.0<br>© 2026 All rights reserved
        </div>
    </nav>

    <main class="main">

        <div class="page-header">
            <div>
                <h2>Consultations</h2>
                <p>Document clinical visits, diagnoses, and treatment plans.</p>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('modal-consult').classList.add('open')">
                + Start Consultation
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

        <!-- Stats -->
        <div class="stat-row">
            <div class="stat-mini">
                <div class="num">{{ $totalCount }}</div>
                <div class="lbl">Total</div>
            </div>
            <div class="stat-mini blue">
                <div class="num" style="color:#1e40af;">{{ $inProgressCount }}</div>
                <div class="lbl">In Progress</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#065f46;">{{ $completedCount }}</div>
                <div class="lbl">Completed</div>
            </div>
            <div class="stat-mini warn">
                <div class="num" style="color:#92400e;">{{ $todayCount }}</div>
                <div class="lbl">Today</div>
            </div>
        </div>

        <!-- Consultation List -->
        <div class="card">
            @if($consultations->count())
                <div class="consult-list">
                    @foreach($consultations as $consult)
                    <div class="consult-card {{ $consult->status === 'in_progress' ? 'active' : '' }}">
                        <div class="consult-top">
                            <div>
                                <div class="consult-name">{{ $consult->patient->full_name }}</div>
                                <div class="consult-meta">
                                    <span>{{ $consult->doctor_name }}</span>
                                    @if($consult->appointment)
                                        <span class="pill {{ $consult->appointment->type === 'telemedicine' ? 'pill-blue' : 'pill-green' }}">
                                            {{ ucfirst($consult->appointment->type) }}
                                        </span>
                                    @else
                                        <span class="pill pill-gray">Walk-in</span>
                                    @endif
                                    <span class="pill {{ $consult->status === 'completed' ? 'pill-green' : 'pill-orange' }}">
                                        {{ $consult->status === 'in_progress' ? 'In Progress' : 'Completed' }}
                                    </span>
                                    <span>{{ $consult->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        @if($consult->status === 'in_progress')
                            <!-- Editable clinical form -->
                            <form method="POST" action="{{ route('consultations.update', $consult) }}">
                                @csrf @method('PATCH')
                                <div class="vitals-row">
                                    <div class="vital-box">
                                        <div class="v-label">BP (mmHg)</div>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:3px;">
                                            <input type="text" name="blood_pressure" value="{{ $consult->blood_pressure }}" placeholder="120/80" style="border:none;text-align:center;font-weight:700;padding:2px;width:60px;"/>
                                        </div>
                                    </div>
                                    <div class="vital-box">
                                        <div class="v-label">Temp (°C)</div>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:3px;">
                                            <input type="text" name="temperature" value="{{ $consult->temperature }}" placeholder="36.8" style="border:none;text-align:center;font-weight:700;padding:2px;width:50px;"/>
                                            <span style="font-size:12px;color:var(--ink-lite);">°C</span>
                                        </div>
                                    </div>
                                    <div class="vital-box">
                                        <div class="v-label">Pulse (bpm)</div>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:3px;">
                                            <input type="text" name="pulse_rate" value="{{ $consult->pulse_rate }}" placeholder="72" style="border:none;text-align:center;font-weight:700;padding:2px;width:50px;"/>
                                            <span style="font-size:12px;color:var(--ink-lite);">bpm</span>
                                        </div>
                                    </div>
                                    <div class="vital-box">
                                        <div class="v-label">Weight (kg)</div>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:3px;">
                                            <input type="text" name="weight" value="{{ $consult->weight }}" placeholder="70" style="border:none;text-align:center;font-weight:700;padding:2px;width:50px;"/>
                                            <span style="font-size:12px;color:var(--ink-lite);">kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clinical-grid">
                                    <div class="clinical-field">
                                        <label>Diagnosis</label>
                                        <textarea name="diagnosis" placeholder="Clinical diagnosis…">{{ $consult->diagnosis }}</textarea>
                                    </div>
                                    <div class="clinical-field">
                                        <label>Treatment Plan</label>
                                        <textarea name="treatment_plan" placeholder="Recommended treatment…">{{ $consult->treatment_plan }}</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="in_progress"/>
                                <div class="consult-actions">
                                    <button type="submit" class="action-btn action-save">💾 Save Notes</button>
                                </div>
                            </form>
                            <div class="consult-actions">
                                <form method="POST" action="{{ route('consultations.update', $consult) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="diagnosis" value="{{ $consult->diagnosis }}"/>
                                    <input type="hidden" name="treatment_plan" value="{{ $consult->treatment_plan }}"/>
                                    <input type="hidden" name="blood_pressure" value="{{ $consult->blood_pressure }}"/>
                                    <input type="hidden" name="temperature" value="{{ $consult->temperature }}"/>
                                    <input type="hidden" name="pulse_rate" value="{{ $consult->pulse_rate }}"/>
                                    <input type="hidden" name="weight" value="{{ $consult->weight }}"/>
                                    <input type="hidden" name="status" value="completed"/>
                                    <button type="submit" class="action-btn action-complete">✅ Complete Consultation</button>
                                </form>
                                <button type="button" class="action-btn action-rx" onclick="openRxModal({{ $consult->id }})">💊 Add Prescription</button>
                                <button type="button" class="action-btn action-lab" onclick="openLabModal({{ $consult->id }})">🔬 Request Lab Test</button>
                            </div>
                        @else
                            <!-- Read-only summary -->
                            <div class="vitals-row">
                                <div class="vital-box"><div class="v-label">BP</div><div class="v-val">{{ $consult->blood_pressure ?? '—' }}</div></div>
                                <div class="vital-box"><div class="v-label">Temp</div><div class="v-val">{{ $consult->temperature ?? '—' }}</div></div>
                                <div class="vital-box"><div class="v-label">Pulse</div><div class="v-val">{{ $consult->pulse_rate ?? '—' }}</div></div>
                                <div class="vital-box"><div class="v-label">Weight</div><div class="v-val">{{ $consult->weight ?? '—' }}</div></div>
                            </div>
                            <div class="clinical-grid">
                                <div class="clinical-field">
                                    <label>Diagnosis</label>
                                    <p style="font-size:13px;color:var(--ink-mid);">{{ $consult->diagnosis ?? '—' }}</p>
                                </div>
                                <div class="clinical-field">
                                    <label>Treatment Plan</label>
                                    <p style="font-size:13px;color:var(--ink-mid);">{{ $consult->treatment_plan ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="consult-actions">
                                <form method="POST" action="{{ route('consultations.destroy', $consult) }}" onsubmit="return confirm('Delete this consultation record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-del">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">📋</div>
                    <p>No consultations recorded yet.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<!-- START CONSULTATION MODAL -->
<div class="modal-overlay" id="modal-consult">
    <div class="modal">
        <h3>📋 Start New Consultation</h3>
        <form method="POST" action="{{ route('consultations.store') }}">
            @csrf
            <div class="form-group">
                <label>Patient *</label>
                <select name="patient_id" required>
                    <option value="">Select patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Doctor *</label>
                <select name="doctor_name" required>
                    <option value="">Select doctor</option>
                    <option value="Dr. Adaeze Okonkwo">Dr. Adaeze Okonkwo</option>
                    <option value="Dr. Emeka Nwosu">Dr. Emeka Nwosu</option>
                    <option value="Dr. Ngozi Eze">Dr. Ngozi Eze</option>
                    <option value="Dr. Tunde Bakare">Dr. Tunde Bakare</option>
                </select>
            </div>
            <div class="form-group">
                <label>Link to Appointment (optional)</label>
                <select name="appointment_id">
                    <option value="">None — walk-in consultation</option>
                    @foreach($availableAppointments as $appt)
                        <option value="{{ $appt->id }}">
                            {{ $appt->patient->full_name }} — {{ $appt->doctor_name }} ({{ $appt->formatted_date }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Presenting Symptoms</label>
                <textarea name="symptoms" placeholder="What is the patient experiencing?"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-consult').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Start Consultation</button>
            </div>
        </form>
    </div>
</div>

<!-- ADD PRESCRIPTION MODAL -->
<div class="modal-overlay" id="modal-rx">
    <div class="modal">
        <h3>💊 Add Prescription</h3>
        <form method="POST" id="rx-form">
            @csrf
            <div class="form-group">
                <label>Medication *</label>
                <input type="text" name="medication" placeholder="e.g. Amoxicillin 500mg" required/>
            </div>
            <div class="form-group">
                <label>Dosage *</label>
                <input type="text" name="dosage" placeholder="e.g. 1 tablet" required/>
            </div>
            <div class="form-group">
                <label>Frequency *</label>
                <select name="frequency" required>
                    <option value="">Select</option>
                    <option value="Once daily">Once daily</option>
                    <option value="Twice daily">Twice daily</option>
                    <option value="3x daily">3x daily</option>
                    <option value="Every 8 hours">Every 8 hours</option>
                    <option value="As needed">As needed (PRN)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Duration (days) *</label>
                <input type="number" name="duration_days" min="1" placeholder="e.g. 7" required/>
            </div>
            <div class="form-group">
                <label>Instructions</label>
                <textarea name="instructions" placeholder="Take with food, avoid alcohol, etc."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-rx').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Issue Prescription</button>
            </div>
        </form>
    </div>
</div>

<!-- REQUEST LAB MODAL -->
<div class="modal-overlay" id="modal-lab">
    <div class="modal">
        <h3>🔬 Request Lab Test</h3>
        <form method="POST" id="lab-form">
            @csrf
            <div class="form-group">
                <label>Test Name *</label>
                <select name="test_name" required>
                    <option value="">Select test</option>
                    <option value="Full Blood Count (FBC)">Full Blood Count (FBC)</option>
                    <option value="Malaria Parasite">Malaria Parasite</option>
                    <option value="Random Blood Sugar">Random Blood Sugar</option>
                    <option value="Fasting Blood Sugar">Fasting Blood Sugar</option>
                    <option value="Urinalysis">Urinalysis</option>
                    <option value="Lipid Profile">Lipid Profile</option>
                    <option value="Liver Function Test">Liver Function Test</option>
                    <option value="Kidney Function Test">Kidney Function Test</option>
                    <option value="Thyroid Function Test">Thyroid Function Test</option>
                    <option value="COVID-19 PCR">COVID-19 PCR</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-lab').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Request Test</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRxModal(consultId) {
        document.getElementById('rx-form').action = '/consultations/' + consultId + '/prescription';
        document.getElementById('modal-rx').classList.add('open');
    }

    function openLabModal(consultId) {
        document.getElementById('lab-form').action = '/consultations/' + consultId + '/lab-request';
        document.getElementById('modal-lab').classList.add('open');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('open');
        });
    });
</script>

</body>
</html>