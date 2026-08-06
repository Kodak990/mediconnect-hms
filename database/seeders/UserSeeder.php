<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@hospital.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Dr. Adaeze Okonkwo',
            'email'    => 'doctor@hospital.com',
            'password' => Hash::make('doc123'),
            'role'     => 'doctor',
        ]);

        User::create([
            'name'     => 'Chioma Adeyemi',
            'email'    => 'patient@hospital.com',
            'password' => Hash::make('pat123'),
            'role'     => 'patient',
        ]);
    }
}