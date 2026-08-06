<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_name',
        'medication',
        'dosage',
        'frequency',
        'duration_days',
        'refills',
        'instructions',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}