<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard() {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, 'Không tìm thấy thông tin bác sĩ.');
        }

        $user = auth()->user();

        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();

        $pendingCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'pending')->count();

        $confirmedCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'confirmed')->count();

        $cancelledCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'cancelled')->count();

        $completedCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')->count();

        return view('dashboard.doctor', compact(
            'user',
            'totalAppointments',
            'pendingCount',
            'confirmedCount',
            'cancelledCount',
            'completedCount'
        ));
    }


    public function confirm(Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $appointment->status = 'confirmed';
        $appointment->save();

        return redirect()->back()->with('success', 'Lịch hẹn đã được xác nhận.');
    }

    public function cancel(Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;
        if ((int) $appointment->doctor_id !== $doctor->id) {
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

    public function appointmentDr() {
        $doctor = auth()->user()->doctor; 
        if (!$doctor) {
            abort(403, 'Không tìm thấy thông tin bác sĩ.');
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
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

        return view('doctor.appointmentdr', compact('appointments', 'slotDisplayMap', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public'); 
            $user->avatar = $path;
        }
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');

        $user->save();


        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }
    public function complete(Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;
        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        if ($appointment->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Chỉ có thể hoàn thành lịch đã xác nhận.');
        }

        $appointment->status = 'completed';
        $appointment->save();

        return redirect()->back()->with('success', 'Lịch hẹn đã được đánh dấu là hoàn thành.');
    }


}
