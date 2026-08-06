<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QueueEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'department',
        'visit_type',
        'priority',
        'status',
        'queue_number',
        'called_at',
        'completed_at',
    ];

    protected $casts = [
        'called_at'    => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($entry) {
            $today = now()->startOfDay();
            $entry->queue_number = QueueEntry::whereDate('created_at', $today)->count() + 1;
        });
    }
}