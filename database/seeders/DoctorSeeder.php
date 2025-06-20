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
            'Khoa thần kinh',
            'Khoa nội tổng quát',
            'Khoa tai - mũi - họng'
        ];

        foreach ($specialties as $name) {
            Specialty::firstOrCreate(['name' => $name]);
        }

        $doctors = [
            ['name' => 'Dr. Nguyễn Hải',    'email' => 'hai@clinic.com',     'specialty' => 'Khoa tim mạch'],
            ['name' => 'Dr. Trần Minh',     'email' => 'minh@clinic.com',    'specialty' => 'Khoa tim mạch'],
            ['name' => 'Dr. Lê Thảo',       'email' => 'thao@clinic.com',    'specialty' => 'Khoa tim mạch'],

            ['name' => 'Dr. Võ An',         'email' => 'an@clinic.com',      'specialty' => 'Khoa da liễu'],
            ['name' => 'Dr. Phạm Nhi',      'email' => 'nhi@clinic.com',     'specialty' => 'Khoa da liễu'],
            ['name' => 'Dr. Hoàng Tuyết',   'email' => 'tuyet@clinic.com',   'specialty' => 'Khoa da liễu'],

            ['name' => 'Dr. Đỗ Khoa',       'email' => 'khoa@clinic.com',    'specialty' => 'Khoa thần kinh'],
            ['name' => 'Dr. Trịnh Hưng',    'email' => 'hung@clinic.com',    'specialty' => 'Khoa thần kinh'],
            ['name' => 'Dr. Mai Vy',        'email' => 'vy@clinic.com',      'specialty' => 'Khoa thần kinh'],

            ['name' => 'Dr. Vũ Hạnh',       'email' => 'hanh@clinic.com',    'specialty' => 'Khoa nội tổng quát'],
            ['name' => 'Dr. Lâm Duy',       'email' => 'duy@clinic.com',     'specialty' => 'Khoa nội tổng quát'],
            ['name' => 'Dr. Nguyễn Quỳnh',  'email' => 'quynh@clinic.com',   'specialty' => 'Khoa nội tổng quát'],

            ['name' => 'Dr. Bùi Khánh',     'email' => 'khanh@clinic.com',   'specialty' => 'Khoa tai - mũi - họng'],
            ['name' => 'Dr. Hồ Thanh',      'email' => 'thanh@clinic.com',   'specialty' => 'Khoa tai - mũi - họng'],
            ['name' => 'Dr. Tạ Yến',        'email' => 'yen@clinic.com',     'specialty' => 'Khoa tai - mũi - họng'],
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
