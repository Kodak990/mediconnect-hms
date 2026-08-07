<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\LabResultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\TelemedicineController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'patient') {
        return redirect()->route('patient.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile — accessible to every authenticated user, no role restriction
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient Portal — patient role only
    Route::middleware('role:patient')->prefix('my')->name('patient.')->group(function () {
        Route::get('/dashboard',     [PatientPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments',  [PatientPortalController::class, 'appointments'])->name('appointments');
        Route::get('/prescriptions', [PatientPortalController::class, 'prescriptions'])->name('prescriptions');
        Route::get('/lab-results',   [PatientPortalController::class, 'labResults'])->name('lab-results');
        Route::get('/bills',         [PatientPortalController::class, 'bills'])->name('bills');
    });

    // Patients — Admin, Doctor, Nurse
    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::resource('patients', PatientController::class);
    });

    // Appointments — Admin, Doctor, Nurse
    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::resource('appointments', AppointmentController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
    });

    // Queue — Admin, Doctor, Nurse
    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
        Route::post('/queue', [QueueController::class, 'store'])->name('queue.store');
        Route::patch('/queue/{queueEntry}', [QueueController::class, 'update'])->name('queue.update');
        Route::delete('/queue/{queueEntry}', [QueueController::class, 'destroy'])->name('queue.destroy');
    });

    // Telemedicine — Admin, Doctor only
    Route::middleware('role:admin,doctor')->group(function () {
        Route::get('/telemedicine', [TelemedicineController::class, 'index'])->name('telemedicine.index');
        Route::post('/telemedicine', [TelemedicineController::class, 'store'])->name('telemedicine.store');
        Route::patch('/telemedicine/{telemedicine}', [TelemedicineController::class, 'update'])->name('telemedicine.update');
        Route::delete('/telemedicine/{telemedicine}', [TelemedicineController::class, 'destroy'])->name('telemedicine.destroy');
    });

    // Consultations — Admin, Doctor, Nurse
    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
        Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
        Route::patch('/consultations/{consultation}', [ConsultationController::class, 'update'])->name('consultations.update');
        Route::delete('/consultations/{consultation}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');
        Route::post('/consultations/{consultation}/prescription', [ConsultationController::class, 'addPrescription'])->name('consultations.prescription');
        Route::post('/consultations/{consultation}/lab-request', [ConsultationController::class, 'addLabRequest'])->name('consultations.lab-request');
    });

    // Prescriptions — Admin, Doctor, Nurse
    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::patch('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
        Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
    });

    // Lab Results — Admin, Doctor, Nurse, Lab
    Route::middleware('role:admin,doctor,nurse,lab')->group(function () {
        Route::get('/lab-results', [LabResultController::class, 'index'])->name('lab-results.index');
        Route::post('/lab-results', [LabResultController::class, 'store'])->name('lab-results.store');
        Route::patch('/lab-results/{labResult}', [LabResultController::class, 'update'])->name('lab-results.update');
        Route::delete('/lab-results/{labResult}', [LabResultController::class, 'destroy'])->name('lab-results.destroy');
    });

    // Billing — Admin, Billing
    Route::middleware('role:admin,billing')->group(function () {
        Route::get('/billing', [InvoiceController::class, 'index'])->name('billing.index');
        Route::post('/billing', [InvoiceController::class, 'store'])->name('billing.store');
        Route::patch('/billing/{invoice}/pay', [InvoiceController::class, 'markPaid'])->name('billing.pay');
        Route::patch('/billing/{invoice}/cancel', [InvoiceController::class, 'cancel'])->name('billing.cancel');
        Route::delete('/billing/{invoice}', [InvoiceController::class, 'destroy'])->name('billing.destroy');
    });

    // Users — Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Reports — Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });