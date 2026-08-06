<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\Patient;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $results = LabResult::with('patient')
            ->when($search, function ($query, $search) {
                $query->where('test_name', 'like', "%$search%")
                      ->orWhere('requested_by', 'like', "%$search%")
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

        $totalTests    = LabResult::count();
        $pendingTests  = LabResult::where('status', 'pending')->count();
        $completedTests = LabResult::where('status', 'completed')->count();
        $abnormalTests = LabResult::where('status', 'abnormal')->count();

        return view('lab-results.index', compact(
            'results', 'search', 'status', 'patients',
            'totalTests', 'pendingTests', 'completedTests', 'abnormalTests'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'test_name'    => 'required|string|max:200',
            'requested_by' => 'required|string|max:100',
            'test_date'    => 'required|date',
            'result'       => 'nullable|string|max:255',
            'reference_range' => 'nullable|string|max:100',
            'status'       => 'required|in:pending,completed,abnormal,reviewed',
            'remarks'      => 'nullable|string',
        ]);

        LabResult::create($request->all());

        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result uploaded successfully.');
    }

    public function update(Request $request, LabResult $labResult)
    {
        $request->validate([
            'status'  => 'required|in:pending,completed,abnormal,reviewed',
            'result'  => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $labResult->update($request->only('status', 'result', 'remarks'));

        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result updated successfully.');
    }

    public function destroy(LabResult $labResult)
    {
        $labResult->delete();

        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result deleted.');
    }
}