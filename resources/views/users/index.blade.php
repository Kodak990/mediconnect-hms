<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — User Management</title>
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
        .stat-mini.green::before { background: linear-gradient(90deg, #065f46, #10b981); }
        .stat-mini.purple::before { background: linear-gradient(90deg, #6d28d9, #8b5cf6); }
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
        .pill-purple { background: #ede9fe; color: #5b21b6; }
        .pill-gray   { background: #f3f4f6; color: #4b5563; }

        .avatar-sm { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); color: white; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; vertical-align: middle; }

        .action-btn { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; margin-right: 4px; transition: all 0.2s; }
        .action-edit { background: #fef3c7; color: #92400e; }
        .action-del  { background: #fee2e2; color: #991b1b; }

        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #065f46; font-size: 14px; font-weight: 500; }
        .alert-error   { background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #991b1b; font-size: 14px; font-weight: 500; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 14px; padding: 28px; max-width: 480px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 18px; color: var(--ink); }

        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        label { font-size: 13px; font-weight: 600; color: var(--ink-mid); }
        input, select { padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.2s; width: 100%; }
        input:focus, select:focus { border-color: var(--teal); }

        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); }

        .error-bag { background: var(--error-bg); border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .error-bag p { color: var(--error); font-size: 13px; margin-bottom: 2px; }

        .role-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;
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
                <h2>User Management</h2>
                <p>Manage all staff and patient accounts.</p>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('modal-user').classList.add('open')">
                + Add User
            </button>
        </div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">❌ {{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="error-bag">
                @foreach($errors->all() as $error)<p>⚠ {{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="stat-row">
            <div class="stat-mini">
                <div class="num">{{ $totalUsers }}</div>
                <div class="lbl">Total Users</div>
            </div>
            <div class="stat-mini blue">
                <div class="num" style="color:#1e40af;">{{ $totalAdmins }}</div>
                <div class="lbl">Admins</div>
            </div>
            <div class="stat-mini green">
                <div class="num" style="color:#065f46;">{{ $totalDoctors }}</div>
                <div class="lbl">Doctors</div>
            </div>
            <div class="stat-mini purple">
                <div class="num" style="color:#5b21b6;">{{ $totalPatients }}</div>
                <div class="lbl">Patients</div>
            </div>
        </div>

        <div class="card">
            <form class="filter-bar" method="GET" action="{{ route('users.index') }}">
                <input type="text" name="search" placeholder="🔍  Search by name or email…" value="{{ $search ?? '' }}"/>
                <select name="role">
                    <option value="">All Roles</option>
                    <option value="admin"     {{ ($role??'')==='admin'     ? 'selected':'' }}>Admin</option>
                    <option value="doctor"    {{ ($role??'')==='doctor'    ? 'selected':'' }}>Doctor</option>
                    <option value="nurse"     {{ ($role??'')==='nurse'     ? 'selected':'' }}>Nurse</option>
                    <option value="patient"   {{ ($role??'')==='patient'   ? 'selected':'' }}>Patient</option>
                    <option value="lab"       {{ ($role??'')==='lab'       ? 'selected':'' }}>Lab Staff</option>
                    <option value="billing"   {{ ($role??'')==='billing'   ? 'selected':'' }}>Billing</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('users.index') }}" class="btn" style="background:#f3f4f6;color:var(--ink-mid);">Clear</a>
            </form>

            @if($users->count())
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="avatar-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span style="font-size:11px;color:var(--teal);font-weight:600;margin-left:6px;">(You)</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleColors = [
                                        'admin'   => 'pill-blue',
                                        'doctor'  => 'pill-green',
                                        'nurse'   => 'pill-orange',
                                        'patient' => 'pill-purple',
                                        'lab'     => 'pill-gray',
                                        'billing' => 'pill-gray',
                                    ];
                                    $roleIcons = [
                                        'admin'   => '🔑',
                                        'doctor'  => '🩺',
                                        'nurse'   => '💉',
                                        'patient' => '🏥',
                                        'lab'     => '🔬',
                                        'billing' => '💳',
                                    ];
                                @endphp
                                <span class="pill {{ $roleColors[$user->role] ?? 'pill-gray' }}">
                                    {{ $roleIcons[$user->role] ?? '👤' }} {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <button class="action-btn action-edit"
                                    onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')">
                                    Change Role
                                </button>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
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
                    {{ $users->links() }}
                </div>

            @else
                <div class="empty-state">
                    <div class="icon">👤</div>
                    <p>No users found.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<!-- ADD USER MODAL -->
<div class="modal-overlay" id="modal-user">
    <div class="modal">
        <h3>👤 Add New User</h3>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name" placeholder="e.g. Dr. Emeka Nwosu" required/>
            </div>
            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" placeholder="user@hospital.com" required/>
            </div>
            <div class="form-group">
                <label>Role *</label>
                <select name="role" required>
                    <option value="">Select role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                    <option value="patient">Patient</option>
                    <option value="lab">Lab Staff</option>
                    <option value="billing">Billing Officer</option>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" placeholder="Min. 6 characters" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password *</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password" required/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-user').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT ROLE MODAL -->
<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <h3>✏️ Change User Role</h3>
        <p style="font-size:14px;color:var(--ink-lite);margin-bottom:18px;">
            Updating role for: <strong id="edit-user-name"></strong>
        </p>
        <form method="POST" id="edit-form">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>New Role *</label>
                <select name="role" id="edit-role" required>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                    <option value="patient">Patient</option>
                    <option value="lab">Lab Staff</option>
                    <option value="billing">Billing Officer</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-edit').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, role) {
        document.getElementById('edit-user-name').textContent = name;
        document.getElementById('edit-role').value = role;
        document.getElementById('edit-form').action = '/users/' + id;
        document.getElementById('modal-edit').classList.add('open');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('open');
        });
    });
</script>

</body>
</html>