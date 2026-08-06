<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Appointments</title>
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

        .action-btn { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; margin-right: 4px; transition: all 0.2s; }
        .action-confirm { background: #d1fae5; color: #065f46; }
        .action-cancel  { background: #fee2e2; color: #991b1b; }
        .action-done    { background: #dbeafe; color: #1e40af; }

        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #065f46; font-size: 14px; font-weight: 500; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }

        .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-mini { background: var(--white); border-radius: 10px; padding: 16px; border: 1px solid var(--border); text-align: center; }
        .stat-mini .num { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--ink); }
        .stat-mini .lbl { font-size: 12px; color: var(--ink-lite); margin-top: 4px; font-weight: 500; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 14px; padding: 28px; max-width: 480px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 16px; color: var(--ink); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 13px; font-weight: 600; color: var(--ink-mid); }
        input, select, textarea { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s; }
        input:focus, select:focus, textarea:focus { border-color: var(--teal); }

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

    @include('partials.sidebar')

    <main class="main">

        <div class="page-header">
            <div>
                <h2>Appointments</h2>
                <p>Book, manage, and track all patient appointments.</p>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('modal-book').classList.add('open')">
                + Book Appointment
            </button>
        </div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-bag">
                @foreach ($errors->all() as $error)
                    <p>⚠ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="stat-row">
            <div class="stat-mini">
                <div class="num">{{ \App\Models\Appointment::count() }}</div>
                <div class="lbl">Total</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#92400e;">{{ \App\Models\Appointment::where('status','pending')->count() }}</div>
                <div class="lbl">Pending</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#065f46;">{{ \App\Models\Appointment::where('status','confirmed')->count() }}</div>
                <div class="lbl">Confirmed</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#1e40af;">{{ \App\Models\Appointment::where('status','completed')->count() }}</div>
                <div class="lbl">Completed</div>
            </div>
        </div>

        <div class="card">
            <form class="filter-bar" method="GET" action="{{ route('appointments.index') }}">
                <input type="text" name="search" placeholder="🔍  Search patient or doctor…" value="{{ $search ?? '' }}"/>
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="pending"   {{ ($status??'')==='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ ($status??'')==='confirmed' ? 'selected':'' }}>Confirmed</option>
                    <option value="completed" {{ ($status??'')==='completed' ? 'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ ($status??'')==='cancelled' ? 'selected':'' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('appointments.index') }}" class="btn" style="background:#f3f4f6;color:var(--ink-mid);">Clear</a>
            </form>

            @if($appointments->count())
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td><strong>{{ $appt->id }}</strong></td>
                            <td><strong>{{ $appt->patient->full_name }}</strong></td>
                            <td>{{ $appt->doctor_name }}</td>
                            <td>{{ $appt->department }}</td>
                            <td>{{ $appt->formatted_date }} at {{ $appt->formatted_time }}</td>
                            <td>
                                <span class="pill {{ $appt->type === 'telemedicine' ? 'pill-blue' : 'pill-green' }}">
                                    {{ ucfirst($appt->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="pill
                                    {{ $appt->status === 'confirmed' ? 'pill-green' : '' }}
                                    {{ $appt->status === 'pending'   ? 'pill-orange' : '' }}
                                    {{ $appt->status === 'cancelled' ? 'pill-red' : '' }}
                                    {{ $appt->status === 'completed' ? 'pill-blue' : '' }}">
                                    {{ ucfirst($appt->status) }}
                                </span>
                            </td>
                            <td>
                                @if($appt->status === 'pending')
                                    <form method="POST" action="{{ route('appointments.update', $appt) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed"/>
                                        <button type="submit" class="action-btn action-confirm">Confirm</button>
                                    </form>
                                    <form method="POST" action="{{ route('appointments.update', $appt) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled"/>
                                        <button type="submit" class="action-btn action-cancel">Cancel</button>
                                    </form>
                                @elseif($appt->status === 'confirmed')
                                    <form method="POST" action="{{ route('appointments.update', $appt) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="completed"/>
                                        <button type="submit" class="action-btn action-done">Complete</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('appointments.destroy', $appt) }}" style="display:inline;" onsubmit="return confirm('Delete this appointment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn action-cancel">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:20px;">
                    {{ $appointments->links() }}
                </div>

            @else
                <div class="empty-state">
                    <div class="icon">📅</div>
                    <p>No appointments found.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<!-- BOOK APPOINTMENT MODAL -->
<div class="modal-overlay" id="modal-book">
    <div class="modal">
        <h3>📅 Book New Appointment</h3>
        <form method="POST" action="{{ route('appointments.store') }}">
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
                    <label>Department *</label>
                    <select name="department" required>
                        <option value="">Select department</option>
                        <option value="General Practice">General Practice</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="Paediatrics">Paediatrics</option>
                        <option value="Surgery">Surgery</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date *</label>
                    <input type="date" name="appointment_date" required/>
                </div>
                <div class="form-group">
                    <label>Time *</label>
                    <input type="time" name="appointment_time" required/>
                </div>
                <div class="form-group">
                    <label>Type *</label>
                    <select name="type" required>
                        <option value="physical">Physical Visit</option>
                        <option value="telemedicine">Telemedicine</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Reason / Complaint</label>
                    <textarea name="reason" placeholder="Brief description of reason for visit…" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-book').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('modal-book').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>

</body>
</html>