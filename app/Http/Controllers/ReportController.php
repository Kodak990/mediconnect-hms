<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Prescription;
use App\Models\LabResult;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Patients
        $totalPatients  = Patient::count();
        $activePatients = Patient::where('status', 'active')->count();

        // Appointments
        $totalAppointments     = Appointment::count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $pendingAppointments   = Appointment::where('status', 'pending')->count();
        $telemedicineCount     = Appointment::where('type', 'telemedicine')->count();
        $physicalCount         = Appointment::where('type', 'physical')->count();

        // Revenue
        $totalRevenue   = Invoice::where('status', 'paid')->sum('amount');
        $pendingRevenue = Invoice::where('status', 'pending')->sum('amount');
        $totalInvoices  = Invoice::count();
        $paidInvoices   = Invoice::where('status', 'paid')->count();

        // Revenue by service
        $revenueByService = Invoice::where('status', 'paid')
            ->selectRaw('service, SUM(amount) as total')
            ->groupBy('service')
            ->orderByDesc('total')
            ->get();

        // Prescriptions
        $totalPrescriptions  = Prescription::count();
        $activePrescriptions = Prescription::where('status', 'active')->count();
        $dispensedPrescriptions = Prescription::where('status', 'dispensed')->count();

        // Lab Results
        $totalLabResults   = LabResult::count();
        $abnormalResults   = LabResult::where('status', 'abnormal')->count();
        $completedResults  = LabResult::where('status', 'completed')->count();
        $pendingResults    = LabResult::where('status', 'pending')->count();

        // Users
        $totalUsers   = User::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalNurses  = User::where('role', 'nurse')->count();

        // Monthly appointments (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $month->format('M'),
                'count' => Appointment::whereYear('created_at', $month->year)
                                      ->whereMonth('created_at', $month->month)
                                      ->count(),
            ];
        }

        return view('reports.index', compact(
            'totalPatients', 'activePatients',
            'totalAppointments', 'completedAppointments', 'pendingAppointments',
            'telemedicineCount', 'physicalCount',
            'totalRevenue', 'pendingRevenue', 'totalInvoices', 'paidInvoices',
            'revenueByService',
            'totalPrescriptions', 'activePrescriptions', 'dispensedPrescriptions',
            'totalLabResults', 'abnormalResults', 'completedResults', 'pendingResults',
            'totalUsers', 'totalDoctors', 'totalNurses',
            'monthlyData'
        ));
    }
}