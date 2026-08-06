<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — My Prescriptions</title>
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

        .presc-list { display: flex; flex-direction: column; gap: 14px; }

        .presc-card { background: var(--white); border-radius: 12px; padding: 20px 22px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); display: flex; gap: 16px; align-items: flex-start; }
        .presc-card.active-card { border-left: 4px solid var(--teal); }
        .presc-icon { width: 44px; height: 44px; border-radius: 10px; background: var(--teal-lite); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .presc-body { flex: 1; }
        .presc-name { font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .presc-meta { display: flex; gap: 16px; flex-wrap: wrap; font-size: 13px; color: var(--ink-lite); margin-bottom: 8px; }
        .presc-meta span { display: flex; align-items: center; gap: 4px; }
        .presc-instructions { font-size: 13px; color: var(--ink-mid); background: var(--cream); border-radius: 6px; padding: 8px 10px; margin-top: 6px; }
        .presc-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 10px; }
        .presc-doctor { font-size: 12px; color: var(--ink-lite); }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-blue   { background: #dbeafe; color: #1e40af; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-gray   { background: #f3f4f6; color: #4b5563; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); background: var(--white); border-radius: 12px; border: 1px solid var(--border); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }
    </style>
</head>
<body>

@include('partials.patient-nav')

<div class="main">

    <div class="page-header">
        <h2>💊 My Prescriptions</h2>
        <p>Medications prescribed to you by your doctor.</p>
    </div>

    @if($prescriptions->count())
        <div class="presc-list">
            @foreach($prescriptions as $presc)
            <div class="presc-card {{ $presc->status === 'active' ? 'active-card' : '' }}">
                <div class="presc-icon">💊</div>
                <div class="presc-body">
                    <div class="presc-name">{{ $presc->medication }}</div>
                    <div class="presc-meta">
                        <span>📏 {{ $presc->dosage }}</span>
                        <span>🔄 {{ $presc->frequency }}</span>
                        <span>📆 {{ $presc->duration_days }} days</span>
                        @if($presc->refills > 0)
                            <span>♻️ {{ $presc->refills }} refill{{ $presc->refills > 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                    @if($presc->instructions)
                        <div class="presc-instructions">📝 {{ $presc->instructions }}</div>
                    @endif
                    <div class="presc-footer">
                        <span class="presc-doctor">Prescribed by {{ $presc->doctor_name }} · {{ $presc->created_at->format('M d, Y') }}</span>
                        <span class="pill
                            {{ $presc->status === 'active'    ? 'pill-green'  : '' }}
                            {{ $presc->status === 'dispensed' ? 'pill-blue'   : '' }}
                            {{ $presc->status === 'expired'   ? 'pill-orange' : '' }}
                            {{ $presc->status === 'cancelled' ? 'pill-gray'   : '' }}">
                            {{ ucfirst($presc->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top:20px;">
            {{ $prescriptions->links() }}
        </div>

    @else
        <div class="empty-state">
            <div class="icon">💊</div>
            <p>No prescriptions on record yet.</p>
        </div>
    @endif

</div>

</body>
</html>