<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;

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

        if(!$appointment->room_number) {
            return redirect()->back()->with('error', 'Vui lòng chọn số phòng trước khi xác nhận lịch hẹn.');
        }

        $sameDay = \Carbon\Carbon::parse($appointment->appointment_time)->toDateString();
        $conflict = Appointment::where('id', '!=', $appointment->id)
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_time', $sameDay)
            ->where('room_number', $appointment->room_number)
            ->where('status', 'confirmed')
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'Phòng này đã được sử dụng cho lịch hẹn khác trong ngày. Vui lòng chọn phòng khác.');
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
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_time', 'asc')
            ->get();

        $rooms = Room::all();

        $bookedRooms = Appointment::whereNotNull('room_number')
            ->pluck('room_number')
            ->toArray();

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

        return view('doctor.appointmentdr', compact(
            'appointments', 'slotDisplayMap', 'user', 'rooms', 'bookedRooms'
        ));
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

    public function history()
    {
        $doctor = auth()->user()->doctor;

        if(!$doctor) {
            abort(403, 'Không tìm thấy thông tin bác sĩ.');
        }
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('appointment_time', 'desc')
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
        return view('doctor.historyapp', compact('appointments', 'slotDisplayMap', 'user'));
    }

    public function updateRoom(Request $request, Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;
        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $request->validate([
            'room_number' => 'required|string|max:10',
        ]);

        $appointment->room_number = $request->input('room_number');
        $appointment->save();

        return redirect()->back()->with('success', 'Cập nhật phòng thành công.');
    }

    public function assignRoom(Request $request, Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;

        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $request->validate([
            'room_number' => 'required|string',
        ]);

        $room = $request->input('room_number');

        $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_time)->toDateString();
        $appointmentTime = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i');

        $isTaken = Appointment::where('id', '!=', $appointment->id)
            ->whereDate('appointment_time', $appointmentDate)
            ->whereTime('appointment_time', $appointmentTime)
            ->where('room_number', $room)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isTaken) {
            return redirect()->back()->with('error', 'Phòng này đã có người đặt trong khung giờ này.');
        }
        $appointment->room_number = $room;
        $appointment->save();

        return redirect()->back()->with('success', 'Đã chọn số phòng thành công.');
    }

    public function deleteDoctorHistory($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('doctor_id', auth()->user()->doctor->id)
            ->firstOrFail();

        $appointment->delete();

        return redirect()->route('doctor.historyapp')->with('success', 'Đã xoá lịch sử cuộc hẹn.');
    }

    public function deleteAllDoctorHistory()
    {
        Appointment::where('doctor_id', auth()->user()->doctor->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->delete();

        return redirect()->route('doctor.historyapp')->with('success', 'Đã xoá tất cả lịch sử cuộc hẹn.');
    }


}
