<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminDoctorController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $specialty_id = $request->input('specialty_id');

        $query = Doctor::with('specialty');

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($specialty_id) {
            $query->where('specialty_id', $specialty_id);
        }

        $doctors = $query->get();
        $allSpecialties = Specialty::all();

        return view('dashboard.admin', compact('doctors', 'allSpecialties'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = User::where('email', $doctor->email)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'specialty_id' => 'required|exists:specialties,id',
        ]);

        $doctor->update([
            'name' => $request->name,
            'email' => $request->email,
            'specialty_id' => $request->specialty_id,
        ]);

        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = User::where('email', $doctor->email)->first();

        $doctor->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Đã xóa bác sĩ.');
    }

    public function edit($id)
{
    $doctor = Doctor::findOrFail($id);
    $specialties = Specialty::all();

    return view('admin.doctors.edit', compact('doctor', 'specialties'));
}


// Hiển thị form thêm bác sĩ
public function create()
{
    $specialties = Specialty::all();
    return view('admin.doctors.create', compact('specialties'));
}

// Lưu bác sĩ mới
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'specialty_id' => 'required|exists:specialties,id',
        'password' => 'required|min:6'
    ]);

    // ✅ Tạo user trước (hash mật khẩu bằng Hash::make)
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'doctor',
        'password' => Hash::make($request->password) // <-- Đây là dòng bạn hỏi
    ]);

    // ✅ Tạo bản ghi doctor gắn với user
    Doctor::create([
        'name' => $request->name,
        'email' => $request->email,
        'user_id' => $user->id,
        'specialty_id' => $request->specialty_id
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Thêm bác sĩ thành công.');
}
}


