<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $invoices = Invoice::with('patient')
            ->when($search, function ($query, $search) {
                $query->where('invoice_number', 'like', "%$search%")
                      ->orWhere('service', 'like', "%$search%")
                      ->orWhereHas('patient', function ($q) use ($search) {
                          $q->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                      });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        $patients = Patient::all();

        $totalRevenue    = Invoice::where('status', 'paid')->sum('amount');
        $pendingAmount   = Invoice::where('status', 'pending')->sum('amount');
        $totalInvoices   = Invoice::count();
        $paidInvoices    = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();

        return view('billing.index', compact(
            'invoices', 'search', 'status', 'patients',
            'totalRevenue', 'pendingAmount', 'totalInvoices',
            'paidInvoices', 'pendingInvoices'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'service'        => 'required|string',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'notes'          => 'nullable|string',
        ]);

        Invoice::create($request->all());

        return redirect()->route('billing.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function markPaid(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $invoice->update([
            'status'         => 'paid',
            'payment_method' => $request->payment_method,
            'paid_at'        => now(),
        ]);

        return redirect()->route('billing.index')
            ->with('success', 'Invoice ' . $invoice->invoice_number . ' marked as paid.');
    }

    public function cancel(Invoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);

        return redirect()->route('billing.index')
            ->with('success', 'Invoice ' . $invoice->invoice_number . ' cancelled.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('billing.index')
            ->with('success', 'Invoice deleted.');
    }
}