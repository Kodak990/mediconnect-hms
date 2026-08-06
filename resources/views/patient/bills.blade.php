<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MediConnect — My Bills</title>
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

        .summary-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .summary-card { background: var(--white); border-radius: 12px; padding: 20px 22px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); position: relative; overflow: hidden; }
        .summary-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal-dark), var(--teal-mid)); }
        .summary-card.warn::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .summary-label { font-size: 11px; font-weight: 700; color: var(--ink-lite); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .summary-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--ink); }
        .summary-sub { font-size: 12px; color: var(--ink-lite); margin-top: 4px; }

        .card { background: var(--white); border-radius: 12px; padding: 22px 24px; border: 1px solid var(--border); box-shadow: 0 1px 6px rgba(0,0,0,0.04); }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { background: var(--teal-lite); color: var(--teal); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; text-align: left; }
        td { padding: 13px 14px; border-bottom: 1px solid var(--border); color: var(--ink-mid); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf8; }

        .pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .pill-green  { background: #d1fae5; color: #065f46; }
        .pill-orange { background: #fef3c7; color: #92400e; }
        .pill-red    { background: #fee2e2; color: #991b1b; }

        .empty-state { text-align: center; padding: 48px 20px; color: var(--ink-lite); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }
    </style>
</head>
<body>

@include('partials.patient-nav')

<div class="main">

    <div class="page-header">
        <h2>💳 My Bills</h2>
        <p>Your invoices and payment history at MediConnect.</p>
    </div>

    <div class="summary-row">
        <div class="summary-card">
            <div class="summary-label">Total Paid</div>
            <div class="summary-value">${{ number_format($totalPaid, 2) }}</div>
            <div class="summary-sub">Settled invoices</div>
        </div>
        <div class="summary-card warn">
            <div class="summary-label">Outstanding Balance</div>
            <div class="summary-value">${{ number_format($totalPending, 2) }}</div>
            <div class="summary-sub">Pending payment — contact reception</div>
        </div>
    </div>

    <div class="card">
        @if($invoices->count())
            <table>
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                        <td>{{ $invoice->service }}</td>
                        <td><strong>{{ $invoice->formatted_amount }}</strong></td>
                        <td>{{ $invoice->payment_method ?? '—' }}</td>
                        <td>
                            <span class="pill
                                {{ $invoice->status === 'paid'      ? 'pill-green'  : '' }}
                                {{ $invoice->status === 'pending'   ? 'pill-orange' : '' }}
                                {{ $invoice->status === 'cancelled' ? 'pill-red'    : '' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:20px;">
                {{ $invoices->links() }}
            </div>

        @else
            <div class="empty-state">
                <div class="icon">💳</div>
                <p>No invoices on record yet.</p>
            </div>
        @endif
    </div>

</div>

</body>
</html>