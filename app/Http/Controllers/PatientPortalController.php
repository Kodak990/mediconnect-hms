<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\LabResult;
use App\Models\Invoice;

class PatientPortalController extends Controller
{
    private function getPatient()
    {
        return Patient::where('email', Auth::user()->email)->first();
    }

    public function dashboard()
    {
        $patient = $this->getPatient();
        if (!$patient) return view('patient.no-record');

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->take(3)
            ->get();

        $activePrescriptions = Prescription::where('patient_id', $patient->id)
            ->where('status', 'active')
            ->count();

        $pendingBills = Invoice::where('patient_id', $patient->id)
            ->where('status', 'pending')
            ->count();

        $pendingBillsAmount = Invoice::where('patient_id', $patient->id)
            ->where('status', 'pending')
            ->sum('amount');

        $totalAppointments = Appointment::where('patient_id', $patient->id)->count();

        return view('patient.dashboard', compact(
            'patient',
            'upcomingAppointments',
            'activePrescriptions',
            'pendingBills',
            'pendingBillsAmount',
            'totalAppointments'
        ));
    }

    public function appointments()
    {
        $patient = $this->getPatient();
        if (!$patient) return view('patient.no-record');

        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.appointments', compact('patient', 'appointments'));
    }

    public function prescriptions()
    {
        $patient = $this->getPatient();
        if (!$patient) return view('patient.no-record');

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.prescriptions', compact('patient', 'prescriptions'));
    }

    public function labResults()
    {
        $patient = $this->getPatient();
        if (!$patient) return view('patient.no-record');

        $results = LabResult::where('patient_id', $patient->id)
            ->whereIn('status', ['completed', 'reviewed'])
            ->orderBy('test_date', 'desc')
            ->paginate(10);

        return view('patient.lab-results', compact('patient', 'results'));
    }

    public function bills()
    {
        $patient = $this->getPatient();
        if (!$patient) return view('patient.no-record');

        $invoices = Invoice::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalPaid    = Invoice::where('patient_id', $patient->id)->where('status', 'paid')->sum('amount');
        $totalPending = Invoice::where('patient_id', $patient->id)->where('status', 'pending')->sum('amount');

        return view('patient.bills', compact('patient', 'invoices', 'totalPaid', 'totalPending'));
    }
}