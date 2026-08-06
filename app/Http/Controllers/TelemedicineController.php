<?php

namespace App\Http\Controllers;

use App\Models\TelemedicineSession;
use App\Models\Appointment;
use Illuminate\Http\Request;

class TelemedicineController extends Controller
{
    public function index()
    {
        $sessions = TelemedicineSession::with(['patient', 'appointment'])
            ->latest()
            ->get();

        // Telemedicine appointments that don't have a session yet
        $availableAppointments = Appointment::with('patient')
            ->where('type', 'telemedicine')
            ->whereDoesntHave('telemedicineSession')
            ->whereIn('status', ['confirmed', 'pending'])
            ->get();

        $scheduledCount   = $sessions->where('status', 'scheduled')->count();
        $inProgressCount  = $sessions->where('status', 'in_progress')->count();
        $completedCount   = $sessions->where('status', 'completed')->count();
        $totalCount       = $sessions->count();

        return view('telemedicine.index', compact(
            'sessions', 'availableAppointments',
            'scheduledCount', 'inProgressCount', 'completedCount', 'totalCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        TelemedicineSession::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => $appointment->patient_id,
            'doctor_name'    => $appointment->doctor_name,
            'status'         => 'scheduled',
        ]);

        return redirect()->route('telemedicine.index')
            ->with('success', 'Telemedicine session scheduled.');
    }

    public function update(Request $request, TelemedicineSession $telemedicine)
    {
        $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'in_progress' && !$telemedicine->started_at) {
            $data['started_at'] = now();
        }

        if ($request->status === 'completed') {
            $data['ended_at'] = now();
            if ($request->filled('session_notes')) {
                $data['session_notes'] = $request->session_notes;
            }
        }

        $telemedicine->update($data);

        // Keep the linked appointment status in sync with the session
        $appointmentStatusMap = [
            'in_progress' => 'confirmed',
            'completed'   => 'completed',
            'cancelled'   => 'cancelled',
        ];

        if (isset($appointmentStatusMap[$request->status]) && $telemedicine->appointment) {
            $telemedicine->appointment->update([
                'status' => $appointmentStatusMap[$request->status],
            ]);
        }

        return redirect()->route('telemedicine.index')
            ->with('success', 'Session updated.');
    }

    public function destroy(TelemedicineSession $telemedicine)
    {
        $telemedicine->delete();

        return redirect()->route('telemedicine.index')
            ->with('success', 'Session removed.');
    }
}