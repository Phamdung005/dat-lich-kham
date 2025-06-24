<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Notification;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function create(Request $request) {
        $doctorId = $request->query('doctor_id'); 
        $doctors = Doctor::all();
        return view('appointments.create', compact('doctors', 'doctorId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_time', $request->appointment_date)
            ->whereTime('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['appointment_time' => 'Giờ này đã được đặt.'])->withInput();
        }

        // Tạo lịch hẹn
        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $datetime,
            'notes' => $request->notes,
        ]);

        // Tạo thông báo cho bệnh nhân
        $doctor = Doctor::findOrFail($request->doctor_id);
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Đặt lịch khám thành công',
            'message' => 'Bạn đã đặt lịch với bác sĩ ' . $doctor->name . ' vào lúc ' . Carbon::parse($datetime)->format('H:i d/m/Y'),
        ]);

        return redirect()->route('appointments.index')->with('success', 'Đặt lịch thành công!');
    }

    public function index() {
        $appointments = Appointment::where('patient_id', auth()->id())
                        ->with('doctor.specialty')
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

        return view('appointments.index', compact('appointments', 'slotDisplayMap'));
    }

    public function edit(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        $date = Carbon::parse($appointment->appointment_time)->format('Y-m-d');
        $doctorId = $appointment->doctor_id;

        $allSlots = [
            '08:00 - 09:30' => '08:00',
            '09:30 - 11:00' => '09:30',
            '11:00 - 12:30' => '11:00',
            '12:30 - 14:00' => '12:30',
            '14:00 - 15:30' => '14:00',
            '15:30 - 17:00' => '15:30',
            '17:00 - 18:30' => '17:00',
        ];

        $booked = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_time', $date)
            ->where('id', '!=', $appointment->id)
            ->pluck('appointment_time')
            ->map(fn($dt) => Carbon::parse($dt)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter($allSlots, function ($time) use ($booked) {
            return !in_array($time, $booked);
        });

        return view('appointments.edit', compact('appointment', 'availableSlots', 'allSlots'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string'
        ]);

        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        $exists = Appointment::where('doctor_id', $appointment->doctor_id)
            ->whereDate('appointment_time', $request->appointment_date)
            ->whereTime('appointment_time', $request->appointment_time)
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['appointment_time' => 'Khung giờ này đã có người đặt.'])->withInput();
        }

        $appointment->update([
            'appointment_time' => $datetime,
            'notes' => $request->notes
        ]);

        return redirect()->route('appointments.index')->with('success', 'Lịch hẹn đã được cập nhật.');
    }

    public function cancel(Appointment $appointment)
{
    // 👇 Thêm dòng này để kiểm tra ID
    //dd($appointment->patient_id, auth()->id());

    if ($appointment->patient_id !== auth()->id()) {
        abort(403);
    }

    if ($appointment->status === 'cancelled') {
        return back()->with('error', 'Lịch hẹn đã bị hủy trước đó.');
    }

    $appointment->update([
        'status' => 'cancelled'
    ]);

    // ✅ Tạo thông báo khi hủy lịch
    \App\Models\Notification::create([
        'user_id' => auth()->id(),
        'title' => 'Hủy lịch hẹn',
        'message' => 'Bạn đã hủy lịch hẹn với bác sĩ ' . $appointment->doctor->name . ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y'),
    ]);

    return redirect()->route('appointments.index')->with('success', 'Lịch hẹn đã được hủy.');
}



    public function getAvailableTimes(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $slotMap = [
            '08:00 - 09:30' => '08:00',
            '09:30 - 11:00' => '09:30',
            '11:00 - 12:30' => '11:00',
            '12:30 - 14:00' => '12:30',
            '14:00 - 15:30' => '14:00',
            '15:30 - 17:00' => '15:30',
            '17:00 - 18:30' => '17:00',
        ];

        $bookedTimes = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_time', $request->date)
            ->pluck('appointment_time')
            ->map(fn($dt) => Carbon::parse($dt)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter(array_keys($slotMap), function ($slot) use ($bookedTimes, $slotMap) {
            return !in_array($slotMap[$slot], $bookedTimes);
        });

        return response()->json(array_values($availableSlots));
    }
}
