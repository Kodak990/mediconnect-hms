<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TelemedicineSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_name',
        'room_code',
        'status',
        'started_at',
        'ended_at',
        'session_notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($session) {
            $session->room_code = strtoupper(Str::random(8));
        });
    }

    public function getDurationAttribute()
    {
        if (!$this->started_at || !$this->ended_at) return null;

        $seconds = $this->started_at->diffInSeconds($this->ended_at);

        if ($seconds < 60) {
            return $seconds . ' sec';
        }

        return round($seconds / 60) . ' min';
    }
}