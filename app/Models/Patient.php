<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'blood_group',
        'genotype',
        'state_of_origin',
        'address',
        'allergies',
        'status',
    ];

    // Full name helper
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Age helper
    public function getAgeAttribute(): int
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}