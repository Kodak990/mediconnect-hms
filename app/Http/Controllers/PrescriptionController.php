<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $prescriptions = Prescription::with('patient')
            ->when($search, function ($query, $search) {
                $query->where('medication', 'like', "%$search%")
                      ->orWhere('doctor_name', 'like', "%$search%")
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

        return view('prescriptions.index', compact(
            'prescriptions', 'search', 'status', 'patients'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'    => 'required|exists:patients,id',
            'doctor_name'   => 'required|string|max:100',
            'medication'    => 'required|string|max:200',
            'dosage'        => 'required|string|max:100',
            'frequency'     => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'refills'       => 'nullable|integer|min:0',
            'instructions'  => 'nullable|string',
        ]);

        Prescription::create($request->all());

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription issued successfully.');
    }

    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'status' => 'required|in:active,dispensed,expired,cancelled',
        ]);

        $prescription->update(['status' => $request->status]);

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription updated successfully.');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription deleted.');
    }
}