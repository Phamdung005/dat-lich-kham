<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        $doctorUser = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@test.com',
            'password' => Hash::make('123456'),
            'role' => 'doctor',
        ]);

        $specialty = Specialty::where('name', 'Khoa tim mạch')->first();

        Doctor::create([
            'name' => 'Dr. Strange',
            'email' => 'doctor@test.com',
            'user_id' => $doctorUser->id,
            'specialty_id' => $specialty->id,
        ]);

        User::create([
            'name' => 'Patient',
            'email' => 'patient@test.com',
            'password' => Hash::make('123456'),
            'role' => 'patient',
        ]);
    }
}
