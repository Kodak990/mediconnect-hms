<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_name',
        'department',
        'appointment_date',
        'appointment_time',
        'type',
        'status',
        'reason',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function telemedicineSession()
    {
        return $this->hasOne(TelemedicineSession::class);
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    public function getFormattedDateAttribute(): string
    {
        return \Carbon\Carbon::parse($this->appointment_date)->format('M d, Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        return \Carbon\Carbon::parse($this->appointment_time)->format('h:i A');
    }
}