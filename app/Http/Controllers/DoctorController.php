<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard() {
        $appointments = Appointment::where('doctor_id', Auth::id())
            ->orderBy('appointment_time', 'asc')
            ->get();

        $slotDisplayMap = [
            '08:00' => '08:00 - 09:30',
            '09:30' => '09:30 - 11:00',
            '11:00' => '11:00 - 12:30',
            '12:30' => '12:30 - 14:00',
            '14:00' => '14:00 - 15:30',
            '15:30' => '15:30 - 17:00',
            '17:00' => '17:00 - 18:30',
        ];

        $user = auth()->user();

        return view('dashboard.doctor', compact('appointments', 'slotDisplayMap', 'user'));
    }

    public function confirm(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->status = 'confirmed';
        $appointment->save();

        return redirect()->back()->with('success', 'Lịch hẹn đã được xác nhận.');
    }

    public function cancel(Appointment $appointment)
    {
        if ((int) $appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->back()->with('success', 'Lịch hẹn đã bị hủy.');
    }


    public function showProfile() {
        $user = auth() -> user();
        return view('doctor.profileDoctor', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public'); 
            $user->avatar = $path;
        }
        $user->phone = $request->input('phone');

        $user->save();


        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

}
