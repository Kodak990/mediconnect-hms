<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — My Lab Results</title>
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

        .main { max-width: 1000px; margin: 0 auto; padding: 32px 24px; }

        .page-header { margin-bottom: 24px; }
        .page-header h2 { font-family: 'Playfair Display', serif; font-size: 1.65rem; color: var(--ink); }
        .page-header p { color: var(--ink-lite); font-size: 14px; margin-top: 3px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { background: var(--teal-lite); color: var(--teal); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; }
        td { padding: 13px 14px; border-bottom: 1px solid var(--border); color: var(--ink-mid); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf8; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green { background: #d1fae5; color: #065f46; }
        .pill-blue  { background: #dbeafe; color: #1e40af; }

        .notice { background: var(--teal-lite); border: 1px solid var(--border); border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 13.5px; color: var(--teal-dark); }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }
    </style>
</head>
<body>

@include('partials.patient-nav')

<div class="main">

    <div class="page-header">
        <h2>🔬 My Lab Results</h2>
        <p>Your completed test results reviewed by your doctor.</p>
    </div>

    <div class="notice">
        ℹ️ Only results that have been completed and reviewed by your doctor are shown here.
    </div>

    <div class="card">
        @if($results->count())
            <table>
                <thead>
                    <tr>
                        <th>Test</th>
                        <th>Result</th>
                        <th>Reference Range</th>
                        <th>Requested By</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td><strong>{{ $result->test_name }}</strong></td>
                        <td>{{ $result->result ?? '—' }}</td>
                        <td>{{ $result->reference_range ?? '—' }}</td>
                        <td>{{ $result->requested_by }}</td>
                        <td>{{ \Carbon\Carbon::parse($result->test_date)->format('M d, Y') }}</td>
                        <td>
                            <span class="pill {{ $result->status === 'reviewed' ? 'pill-blue' : 'pill-green' }}">
                                {{ ucfirst($result->status) }}
                            </span>
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
                <p>No lab results available yet.</p>
            </div>
        @endif
    </div>

</div>

</body>
</html>