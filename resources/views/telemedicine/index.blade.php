<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Telemedicine</title>
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
        .stat-mini.blue::before { background: linear-gradient(90deg, #1d4ed8, #3b82f6); }
        .stat-mini.warn::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-mini .num { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--ink); }
        .stat-mini .lbl { font-size: 12px; color: var(--ink-lite); margin-top: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); margin-bottom: 20px; }

        .session-list { display: flex; flex-direction: column; gap: 12px; }

        .session-card {
            display: flex; align-items: center; gap: 16px;
            background: var(--cream); border: 1.5px solid var(--border);
            border-radius: 10px; padding: 16px 18px; transition: all 0.2s;
        }

        .session-card.live { border-color: var(--teal); background: var(--teal-lite); }

        .s-icon {
            width: 48px; height: 48px; border-radius: 12px;
            background: var(--teal); color: white; font-size: 20px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .s-icon.live { background: #1e40af; }
        .s-icon.done { background: #6b7280; }

        .s-body { flex: 1; }
        .s-name { font-weight: 700; font-size: 15px; color: var(--ink); }
        .s-meta { font-size: 12px; color: var(--ink-lite); margin-top: 3px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

        .room-code {
            font-family: monospace; background: var(--white); border: 1px solid var(--border);
            padding: 1px 8px; border-radius: 6px; font-size: 11px; color: var(--teal); font-weight: 700;
        }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-red    { background: #fee2e2; color: #991b1b; }
        .pill-gray   { background: #f3f4f6; color: #4b5563; }

        .s-actions { display: flex; gap: 8px; }

        .action-btn { padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
        .action-start    { background: var(--teal); color: white; }
        .action-join      { background: #1e40af; color: white; }
        .action-complete { background: #d1fae5; color: #065f46; }
        .action-cancel   { background: #fee2e2; color: #991b1b; }
        .action-del      { background: #f3f4f6; color: #4b5563; }

        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #065f46; font-size: 14px; font-weight: 500; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 14px; padding: 28px; max-width: 480px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 18px; color: var(--ink); }

        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
        label { font-size: 13px; font-weight: 600; color: var(--ink-mid); }
        select, textarea { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s; width: 100%; }
        select:focus, textarea:focus { border-color: var(--teal); }
        textarea { resize: vertical; min-height: 80px; }

        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); }

        .error-bag { background: var(--error-bg); border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }

        .notes-box {
            background: var(--white); border: 1px solid var(--border); border-radius: 8px;
            padding: 10px 12px; font-size: 13px; color: var(--ink-mid); margin-top: 8px;
        }
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
                <h2>Telemedicine Sessions</h2>
                <p>Schedule, run, and review remote consultations.</p>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('modal-session').classList.add('open')">
                + Schedule Session
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
                <div class="num">{{ $totalCount }}</div>
                <div class="lbl">Total Sessions</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#065f46;">{{ $scheduledCount }}</div>
                <div class="lbl">Scheduled</div>
            </div>
            <div class="stat-mini blue">
                <div class="num" style="color:#1e40af;">{{ $inProgressCount }}</div>
                <div class="lbl">Live Now</div>
            </div>
            <div class="stat-mini warn">
                <div class="num" style="color:#92400e;">{{ $completedCount }}</div>
                <div class="lbl">Completed</div>
            </div>
        </div>

        <div class="card">
            @if($sessions->count())
                <div class="session-list">
                    @foreach($sessions as $session)
                    <div class="session-card {{ $session->status === 'in_progress' ? 'live' : '' }}">
                        <div class="s-icon {{ $session->status === 'in_progress' ? 'live' : '' }} {{ $session->status === 'completed' || $session->status === 'cancelled' ? 'done' : '' }}">
                            📹
                        </div>
                        <div class="s-body">
                            <div class="s-name">{{ $session->patient->full_name }}</div>
                            <div class="s-meta">
                                <span>{{ $session->doctor_name }}</span>
                                <span class="room-code">{{ $session->room_code }}</span>
                                <span class="pill
                                    {{ $session->status === 'scheduled'   ? 'pill-green'  : '' }}
                                    {{ $session->status === 'in_progress' ? 'pill-blue'   : '' }}
                                    {{ $session->status === 'completed'   ? 'pill-gray'   : '' }}
                                    {{ $session->status === 'cancelled'   ? 'pill-red'    : '' }}">
                                    {{ $session->status === 'in_progress' ? 'Live Now' : ucfirst($session->status) }}
                                </span>
                                @if($session->duration)
                                    <span>⏱ {{ $session->duration }}</span>
                                @endif
                            </div>
                            @if($session->session_notes)
                                <div class="notes-box">📝 {{ $session->session_notes }}</div>
                            @endif
                        </div>
                        <div class="s-actions">
                            @if($session->status === 'scheduled')
                                <form method="POST" action="{{ route('telemedicine.update', $session) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress"/>
                                    <button type="submit" class="action-btn action-start">Start Session</button>
                                </form>
                                <form method="POST" action="{{ route('telemedicine.update', $session) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled"/>
                                    <button type="submit" class="action-btn action-cancel">Cancel</button>
                                </form>
                            @elseif($session->status === 'in_progress')
                                <button class="action-btn action-join" onclick="alert('Joining room {{ $session->room_code }}… (demo only)')">Join Call</button>
                                <button class="action-btn action-complete" onclick="openEndModal({{ $session->id }})">End Session</button>
                            @else
                                <form method="POST" action="{{ route('telemedicine.destroy', $session) }}" style="display:inline;" onsubmit="return confirm('Delete this session record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-del">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">📹</div>
                    <p>No telemedicine sessions yet.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<!-- SCHEDULE SESSION MODAL -->
<div class="modal-overlay" id="modal-session">
    <div class="modal">
        <h3>📹 Schedule Telemedicine Session</h3>
        @if($availableAppointments->count())
            <form method="POST" action="{{ route('telemedicine.store') }}">
                @csrf
                <div class="form-group">
                    <label>Telemedicine Appointment *</label>
                    <select name="appointment_id" required>
                        <option value="">Select appointment</option>
                        @foreach($availableAppointments as $appt)
                            <option value="{{ $appt->id }}">
                                {{ $appt->patient->full_name }} — {{ $appt->doctor_name }} ({{ $appt->formatted_date }} {{ $appt->formatted_time }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-session').classList.remove('open')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Schedule Session</button>
                </div>
            </form>
        @else
            <p style="font-size:14px;color:var(--ink-lite);margin-bottom:18px;">
                No telemedicine appointments available to schedule. Book a telemedicine-type appointment first from the Appointments page.
            </p>
            <div class="modal-footer">
                <a href="{{ route('appointments.index') }}" class="btn btn-primary">Go to Appointments</a>
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-session').classList.remove('open')">Close</button>
            </div>
        @endif
    </div>
</div>

<!-- END SESSION MODAL -->
<div class="modal-overlay" id="modal-end">
    <div class="modal">
        <h3>✅ End Telemedicine Session</h3>
        <form method="POST" id="end-form">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="completed"/>
            <div class="form-group">
                <label>Session Notes</label>
                <textarea name="session_notes" placeholder="Summary of consultation, advice given, follow-up needed…"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-end').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">End Session</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEndModal(id) {
        document.getElementById('end-form').action = '/telemedicine/' + id;
        document.getElementById('modal-end').classList.add('open');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('open');
        });
    });
</script>

</body>
</html>