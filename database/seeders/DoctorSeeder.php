<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {

        $specialties = [
            'Khoa tim mạch',
            'Khoa da liễu',
            'Khoa thần kinh'
        ];

        foreach ($specialties as $name) {
            Specialty::firstOrCreate(['name' => $name]);
        }

        $doctors = [
            ['name' => 'Dr. A', 'email' => 'a@clinic.com', 'specialty' => 'Khoa tim mạch'],
            ['name' => 'Dr. B', 'email' => 'b@clinic.com', 'specialty' => 'Khoa da liễu'],
            ['name' => 'Dr. C', 'email' => 'c@clinic.com', 'specialty' => 'Khoa than kinh'],
            ['name' => 'Dr. D', 'email' => 'd@clinic.com', 'specialty' => 'Khoa tim mạch'],
            ['name' => 'Dr. E', 'email' => 'e@clinic.com', 'specialty' => 'Khoa da liễu'],
        ];

        foreach ($doctors as $doc) {
            $user = User::create([
                'name' => $doc['name'],
                'email' => $doc['email'],
                'password' => Hash::make('123456'), 
                'role' => 'doctor',
            ]);

            $specialty = Specialty::where('name', $doc['specialty'])->first();

            Doctor::create([
                'name' => $doc['name'],
                'email' => $doc['email'],
                'user_id' => $user->id,
                'specialty_id' => $specialty->id,
            ]);
        }
    }
}
