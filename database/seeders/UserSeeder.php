<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hospital.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'doctor@hospital.com'],
            [
                'name'     => 'Dr. Adaeze Okonkwo',
                'password' => Hash::make('doc123'),
                'role'     => 'doctor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'patient@hospital.com'],
            [
                'name'     => 'Chioma Adeyemi',
                'password' => Hash::make('pat123'),
                'role'     => 'patient',
            ]
        );
    }
}