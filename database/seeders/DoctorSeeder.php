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
            ['name' => 'TS.BS. Chu Trọng Hiệp', 'email' => 'hiep@clinic.com', 'specialty' => 'Khoa tim mạch', 'phone' => '0901234567', 'avatar' => 'avatars/avatar-TS.BS_.Chu-Trong-Hiep-300x300.webp'],
            ['name' => 'ThS.BS. Phạm Minh Cường', 'email' => 'cuong@clinic.com', 'specialty' => 'Khoa tim mạch', 'phone' => '0902345678', 'avatar' => 'avatars/13.-BS-PHAM-MINH-CUONG-1160x650-1-300x300.png'],
            ['name' => 'ThS.BS. Trần Tử Nam', 'email' => 'nam@clinic.com', 'specialty' => 'Khoa tim mạch', 'phone' => '0902233442', 'avatar' => 'avatars/avatar-bacsi-tran-tu-nam_resize.webp'],
            ['name' => 'BS. Từ Thị Thu Hà', 'email' => 'ha@clinic.com', 'specialty' => 'Khoa tim mạch', 'phone' => '0902230042', 'avatar' => 'avatars/Tu-Thi-Thu-Ha-2024.jpg'],
            ['name' => 'ThS.BS. Trần Thị Quỳnh Trang', 'email' => 'trang@clinic.com', 'specialty' => 'Khoa tim mạch', 'phone' => '0902239832', 'avatar' => 'avatars/TUN04778_63fc7386e06b1tranthiquynhtrang.jpg'],

            ['name' => 'BS. Mai Thị Cẩm Cát', 'email' => 'cat@clinic.com', 'specialty' => 'Khoa da liễu', 'phone' => '0905966789', 'avatar' => 'avatars/_62A1618_637ee78178988maithicamcat.jpg'],
            ['name' => 'ThS.BS. Đỗ Thị Huyền', 'email' => 'huyen@clinic.com', 'specialty' => 'Khoa da liễu', 'phone' => '0333947387', 'avatar' => 'avatars/BS-DO-THI-HUYEN-KHOA-NOI-TONG-QUAT_taimuihongsg.jpg'],
            ['name' => 'BS. Lâm Thị Ngọc Bích', 'email' => 'bich@clinic.com', 'specialty' => 'Khoa da liễu', 'phone' => '0822736521', 'avatar' => 'avatars/BS-LAM-THI-NGOC-BICH-KHOA-NOI-TONG-QUAT_taimuihongsg.jpg'],
            ['name' => 'BS. Phan Công Long', 'email' => 'long@clinic.com', 'specialty' => 'Khoa da liễu', 'phone' => '0882446521', 'avatar' => 'avatars/z5989391719509_066157aa32c9bbc8f85579027ae01eb2-scaledphanconglong.jpg'],

            ['name' => 'BS. Nguyễn Thị Tuyết Mai', 'email' => 'mai@clinic.com', 'specialty' => 'Khoa thần kinh', 'phone' => '0223423434', 'avatar' => 'avatars/BS-NGUYEN-THI-TUYET-MAI-KHOA-NOI-TONG-QUAT_taimuihongsg.jpg'],
            ['name' => 'BS. Nguyễn Tuấn Thanh', 'email' => 'thanh@clinic.com', 'specialty' => 'Khoa thần kinh', 'phone' => '0901234568', 'avatar' => 'avatars/BS-NGUYEN-TUAN-THANH-KHOA-NOI-TONG-QUAT_taimuihongsg.jpg'],
            ['name' => 'BS. Hồ Thanh Hùng', 'email' => 'hung@clinic.com', 'specialty' => 'Khoa thần kinh', 'phone' => '0277356252', 'avatar' => 'avatars/BS.-Ho-Thanh-Hung.jpg'],

            ['name' => 'BS. Nguyễn Thanh Bảo Thy', 'email' => 'thy@clinic.com', 'specialty' => 'Khoa nội tổng quát', 'phone' => '0666333772', 'avatar' => 'avatars/BS.-Nguyen-Thanh-Bao-Thy.jpg'],
            ['name' => 'ThS.BS. Bùi Nguyên Thông', 'email' => 'thong@clinic.com', 'specialty' => 'Khoa nội tổng quát', 'phone' => '0669333772', 'avatar' => 'avatars/Bui-Nguyen-Thong-1024x768-1.jpg'],
            ['name' => 'BS. Hoàng Anh', 'email' => 'anh@clinic.com', 'specialty' => 'Khoa nội tổng quát', 'phone' => '0666333792', 'avatar' => 'avatars/ChandungBsHoangAnh_637ee680ea59c.jpg'],

            ['name' => 'ThS.BS. Mai Tiến Dũng', 'email' => 'dung@clinic.com', 'specialty' => 'Khoa tai - mũi - họng', 'phone' => '0669933772', 'avatar' => 'avatars/MAI-TIEN-DUNG.png'],
            ['name' => 'BS. Phan Phước Hoàng Minh', 'email' => 'minh@clinic.com', 'specialty' => 'Khoa tai - mũi - họng', 'phone' => '0698933772', 'avatar' => 'avatars/PHAN-PHUOC-HOANG-MINH.png'],
            ['name' => 'BS. Trần Công Hậu', 'email' => 'hau@clinic.com', 'specialty' => 'Khoa tai - mũi - họng', 'phone' => '0669936772', 'avatar' => 'avatars/TRAN-CONG-HAU.png'],
        ];

        foreach ($doctors as $doc) {
            $user = User::create([
                'name' => $doc['name'],
                'email' => $doc['email'],
                'password' => Hash::make('123456'),
                'role' => 'doctor',
                'phone' => $doc['phone'] ?? null,
                'avatar' => $doc['avatar'] ?? null,
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
