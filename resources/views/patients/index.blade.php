<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — Patients</title>
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

        .topbar {
            height: 62px; background: var(--white); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; padding: 0 28px; gap: 16px;
            position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.04);
        }

        .topbar-brand { display: flex; align-items: center; gap: 10px; flex: 1; }
        .topbar-brand .icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .topbar-brand h1 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--teal-dark); }

        .btn-logout { background: none; border: 1.5px solid var(--border); color: var(--ink-mid); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; }

        .layout { display: flex; }

        .sidebar { width: 240px; background: var(--white); border-right: 1px solid var(--border); padding: 20px 0; position: sticky; top: 62px; height: calc(100vh - 62px); overflow-y: auto; display: flex; flex-direction: column; }
        .nav-section { padding: 16px 20px 6px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ink-lite); }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: var(--ink-mid); font-size: 14px; cursor: pointer; border-left: 3px solid transparent; transition: all 0.15s; font-weight: 500; text-decoration: none; }
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

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); margin-bottom: 20px; }

        .search-bar { display: flex; gap: 12px; margin-bottom: 20px; }
        .search-bar input { flex: 1; padding: 10px 16px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; outline: none; color: var(--ink); transition: border-color 0.2s; }
        .search-bar input:focus { border-color: var(--teal); }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { background: var(--teal-lite); color: var(--teal); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--ink-mid); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf8; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green { background: #d1fae5; color: #065f46; }
        .pill-red   { background: #fee2e2; color: #991b1b; }
        .pill-blue  { background: #dbeafe; color: #1e40af; }

        .action-btn { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none; display: inline-block; margin-right: 4px; transition: all 0.2s; }
        .action-view { background: var(--teal-lite); color: var(--teal); }
        .action-edit { background: #fef3c7; color: #92400e; }
        .action-del  { background: #fee2e2; color: #991b1b; }

        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #065f46; font-size: 14px; font-weight: 500; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; margin-bottom: 16px; }

        .avatar-sm { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--teal-dark), var(--teal)); color: white; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; vertical-align: middle; }
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
                <h2>Patient Records</h2>
                <p>Browse, register, and manage all patient profiles.</p>
            </div>
            <a href="{{ route('patients.create') }}" class="btn btn-primary">+ Register Patient</a>
        </div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="card">
            <form class="search-bar" method="GET" action="{{ route('patients.index') }}">
                <input type="text" name="search" placeholder="🔍  Search by name or phone number…" value="{{ $search ?? '' }}"/>
                <button type="submit" class="btn btn-primary">Search</button>
                @if($search)
                    <a href="{{ route('patients.index') }}" class="btn" style="background:#f3f4f6;color:var(--ink-mid);">Clear</a>
                @endif
            </form>

            @if($patients->count())
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Blood Group</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>
                                <div class="avatar-sm">{{ strtoupper(substr($patient->first_name, 0, 1)) }}</div>
                                <strong>{{ $patient->full_name }}</strong>
                            </td>
                            <td>{{ $patient->age }} yrs</td>
                            <td>{{ $patient->gender }}</td>
                            <td><span class="pill pill-blue">{{ $patient->blood_group }}</span></td>
                            <td>{{ $patient->phone }}</td>
                            <td>
                                <span class="pill {{ $patient->status === 'active' ? 'pill-green' : 'pill-red' }}">
                                    {{ ucfirst($patient->status) }}
                                </span>
                            </td>
                            <td>{{ $patient->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('patients.show', $patient) }}" class="action-btn action-view">View</a>
                                <a href="{{ route('patients.edit', $patient) }}" class="action-btn action-edit">Edit</a>
                                <form method="POST" action="{{ route('patients.destroy', $patient) }}" style="display:inline;" onsubmit="return confirm('Remove this patient?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-del">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:20px;">
                    {{ $patients->links() }}
                </div>

            @else
                <div class="empty-state">
                    <div class="icon">👥</div>
                    <p>No patients found{{ $search ? ' for "'.$search.'"' : '' }}.</p>
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">+ Register First Patient</a>
                </div>
            @endif
        </div>

    </main>
</div>

</body>
</html>