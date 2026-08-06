<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Live Queue</title>
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

        .queue-list { display: flex; flex-direction: column; gap: 12px; }

        .queue-card {
            display: flex; align-items: center; gap: 16px;
            background: var(--cream); border: 1.5px solid var(--border);
            border-radius: 10px; padding: 16px 18px; transition: all 0.2s;
        }

        .queue-card.urgent { border-color: #fde68a; background: #fffbeb; }
        .queue-card.emergency { border-color: #fecaca; background: #fef2f2; }
        .queue-card.in-progress { border-color: var(--teal); background: var(--teal-lite); }

        .q-number {
            width: 48px; height: 48px; border-radius: 12px;
            background: var(--teal); color: white;
            font-family: 'Playfair Display', serif; font-weight: 800; font-size: 18px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .q-number.urgent { background: #d97706; }
        .q-number.emergency { background: #dc2626; }

        .q-body { flex: 1; }
        .q-name { font-weight: 700; font-size: 15px; color: var(--ink); }
        .q-meta { font-size: 12px; color: var(--ink-lite); margin-top: 3px; display: flex; gap: 10px; align-items: center; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-red    { background: #fee2e2; color: #991b1b; }

        .q-actions { display: flex; gap: 8px; }

        .action-btn { padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
        .action-call     { background: var(--teal); color: white; }
        .action-complete { background: #d1fae5; color: #065f46; }
        .action-cancel   { background: #fee2e2; color: #991b1b; }

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
        input, select { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s; width: 100%; }
        input:focus, select:focus { border-color: var(--teal); }

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
                <h2>Live Patient Queue</h2>
                <p>Track and manage today's walk-ins and waiting patients.</p>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('modal-queue').classList.add('open')">
                + Add to Queue
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
                <div class="num">{{ $waitingCount }}</div>
                <div class="lbl">Waiting</div>
            </div>
            <div class="stat-mini blue">
                <div class="num" style="color:#1e40af;">{{ $inProgressCount }}</div>
                <div class="lbl">In Progress</div>
            </div>
            <div class="stat-mini danger">
                <div class="num" style="color:#991b1b;">{{ $emergencyCount }}</div>
                <div class="lbl">Emergency</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#065f46;">{{ $completedToday }}</div>
                <div class="lbl">Completed Today</div>
            </div>
        </div>

        <div class="card">
            @if($queue->count())
                <div class="queue-list">
                    @foreach($queue as $entry)
                    <div class="queue-card
                        {{ $entry->priority === 'urgent' ? 'urgent' : '' }}
                        {{ $entry->priority === 'emergency' ? 'emergency' : '' }}
                        {{ $entry->status === 'in_progress' ? 'in-progress' : '' }}">
                        <div class="q-number
                            {{ $entry->priority === 'urgent' ? 'urgent' : '' }}
                            {{ $entry->priority === 'emergency' ? 'emergency' : '' }}">
                            {{ $entry->priority === 'emergency' ? 'E' . $entry->queue_number : $entry->queue_number }}
                        </div>
                        <div class="q-body">
                            <div class="q-name">{{ $entry->patient->full_name }}</div>
                            <div class="q-meta">
                                <span>{{ $entry->department }}</span>
                                <span class="pill {{ $entry->visit_type === 'telemedicine' ? 'pill-blue' : ($entry->visit_type === 'emergency' ? 'pill-red' : 'pill-green') }}">
                                    {{ ucfirst($entry->visit_type) }}
                                </span>
                                @if($entry->priority !== 'normal')
                                    <span class="pill {{ $entry->priority === 'emergency' ? 'pill-red' : 'pill-orange' }}">
                                        {{ ucfirst($entry->priority) }}
                                    </span>
                                @endif
                                @if($entry->status === 'in_progress')
                                    <span class="pill pill-blue">In Progress</span>
                                @endif
                            </div>
                        </div>
                        <div class="q-actions">
                            @if($entry->status === 'waiting')
                                <form method="POST" action="{{ route('queue.update', $entry) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress"/>
                                    <button type="submit" class="action-btn action-call">Call In</button>
                                </form>
                                <form method="POST" action="{{ route('queue.update', $entry) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled"/>
                                    <button type="submit" class="action-btn action-cancel">Cancel</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('queue.update', $entry) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="completed"/>
                                    <button type="submit" class="action-btn action-complete">Complete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">🚶</div>
                    <p>No patients in the queue right now.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<!-- ADD TO QUEUE MODAL -->
<div class="modal-overlay" id="modal-queue">
    <div class="modal">
        <h3>🚶 Add Patient to Queue</h3>
        <form method="POST" action="{{ route('queue.store') }}">
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
                <label>Visit Type *</label>
                <select name="visit_type" required>
                    <option value="physical">Physical Visit</option>
                    <option value="telemedicine">Telemedicine</option>
                    <option value="emergency">Emergency</option>
                </select>
            </div>
            <div class="form-group">
                <label>Priority *</label>
                <select name="priority" required>
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                    <option value="emergency">Emergency</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-queue').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add to Queue</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('modal-queue').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>

</body>
</html>