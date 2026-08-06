<?php

namespace App\Http\Controllers;

use App\Models\QueueEntry;
use App\Models\Patient;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $queue = QueueEntry::with('patient')
            ->whereDate('created_at', $today)
            ->whereIn('status', ['waiting', 'in_progress'])
            ->orderByRaw("CASE priority WHEN 'emergency' THEN 0 WHEN 'urgent' THEN 1 ELSE 2 END")
            ->orderBy('queue_number')
            ->get();

        $completedToday = QueueEntry::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $waitingCount    = $queue->where('status', 'waiting')->count();
        $inProgressCount = $queue->where('status', 'in_progress')->count();
        $emergencyCount  = $queue->where('priority', 'emergency')->count();

        $patients = Patient::all();

        return view('queue.index', compact(
            'queue', 'completedToday', 'waitingCount',
            'inProgressCount', 'emergencyCount', 'patients'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'department' => 'required|string',
            'visit_type'  => 'required|in:physical,telemedicine,emergency',
            'priority'    => 'required|in:normal,urgent,emergency',
        ]);

        QueueEntry::create($request->all());

        return redirect()->route('queue.index')
            ->with('success', 'Patient added to queue successfully.');
    }

    public function update(Request $request, QueueEntry $queueEntry)
    {
        $request->validate([
            'status' => 'required|in:waiting,in_progress,completed,cancelled',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'in_progress') {
            $data['called_at'] = now();
        }

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
        }

        $queueEntry->update($data);

        return redirect()->route('queue.index')
            ->with('success', 'Queue status updated.');
    }

    public function destroy(QueueEntry $queueEntry)
    {
        $queueEntry->delete();

        return redirect()->route('queue.index')
            ->with('success', 'Removed from queue.');
    }
}