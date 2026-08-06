<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\LabResult;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['patient', 'appointment'])
            ->latest()
            ->get();

        $patients = Patient::all();

        // Appointments without a consultation yet, confirmed or completed
        $availableAppointments = Appointment::with('patient')
            ->whereDoesntHave('consultation')
            ->whereIn('status', ['confirmed', 'completed'])
            ->get();

        $totalCount      = $consultations->count();
        $inProgressCount = $consultations->where('status', 'in_progress')->count();
        $completedCount  = $consultations->where('status', 'completed')->count();
        $todayCount      = $consultations->where('created_at', '>=', now()->startOfDay())->count();

        return view('consultations.index', compact(
            'consultations', 'patients', 'availableAppointments',
            'totalCount', 'inProgressCount', 'completedCount', 'todayCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'doctor_name'    => 'required|string',
            'symptoms'       => 'nullable|string',
        ]);

        Consultation::create($request->all());

        return redirect()->route('consultations.index')
            ->with('success', 'Consultation started.');
    }

    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'diagnosis'      => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'temperature'    => 'nullable|string',
            'pulse_rate'     => 'nullable|string',
            'weight'         => 'nullable|string',
            'status'         => 'required|in:in_progress,completed',
        ]);

        $consultation->update($request->all());

        if ($request->status === 'completed' && $consultation->appointment) {
            $consultation->appointment->update(['status' => 'completed']);
        }

        return redirect()->route('consultations.index')
            ->with('success', 'Consultation updated.');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('consultations.index')
            ->with('success', 'Consultation deleted.');
    }

    // Quick-create a prescription directly from a consultation
    public function addPrescription(Request $request, Consultation $consultation)
    {
        $request->validate([
            'medication'    => 'required|string',
            'dosage'        => 'required|string',
            'frequency'     => 'required|string',
            'duration_days' => 'required|integer|min:1',
        ]);

        Prescription::create([
            'patient_id'    => $consultation->patient_id,
            'doctor_name'   => $consultation->doctor_name,
            'medication'    => $request->medication,
            'dosage'        => $request->dosage,
            'frequency'     => $request->frequency,
            'duration_days' => $request->duration_days,
            'refills'       => $request->refills ?? 0,
            'instructions'  => $request->instructions,
            'status'        => 'active',
        ]);

        return redirect()->route('consultations.index')
            ->with('success', 'Prescription issued from consultation.');
    }

    // Quick-create a lab request directly from a consultation
    public function addLabRequest(Request $request, Consultation $consultation)
    {
        $request->validate([
            'test_name' => 'required|string',
        ]);

        LabResult::create([
            'patient_id'   => $consultation->patient_id,
            'test_name'    => $request->test_name,
            'requested_by' => $consultation->doctor_name,
            'test_date'    => now()->format('Y-m-d'),
            'status'       => 'pending',
        ]);

        return redirect()->route('consultations.index')
            ->with('success', 'Lab test requested from consultation.');
    }
}