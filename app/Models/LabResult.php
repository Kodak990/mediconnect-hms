<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'test_name',
        'requested_by',
        'result',
        'reference_range',
        'status',
        'remarks',
        'test_date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}