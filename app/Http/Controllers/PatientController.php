<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Show all patients
    public function index(Request $request)
    {
        $search = $request->get('search');

        $patients = Patient::when($search, function ($query, $search) {
            $query->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
        })->latest()->paginate(10);

        return view('patients.index', compact('patients', 'search'));
    }

    // Show register form
    public function create()
    {
        return view('patients.create');
    }

    // Save new patient
    public function store(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'date_of_birth'   => 'required|date',
            'gender'          => 'required|in:Male,Female',
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:255|unique:patients,email',
            'blood_group'     => 'required|string|max:5',
            'genotype'        => 'nullable|in:AA,AS,SS,AC',
            'state_of_origin' => 'nullable|string|max:100',
            'address'         => 'nullable|string',
            'allergies'       => 'nullable|string|max:255',
        ]);

        Patient::create($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Patient registered successfully.');
    }

    // Show single patient
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    // Show edit form
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    // Update patient
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'date_of_birth'   => 'required|date',
            'gender'          => 'required|in:Male,Female',
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:255|unique:patients,email,' . $patient->id,
            'blood_group'     => 'required|string|max:5',
            'genotype'        => 'nullable|in:AA,AS,SS,AC',
            'state_of_origin' => 'nullable|string|max:100',
            'address'         => 'nullable|string',
            'allergies'       => 'nullable|string|max:255',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    // Delete patient
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient removed.');
    }
}