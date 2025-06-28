<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Notification;

class DoctorAppointmentController extends Controller
{
    public function confirm(Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Lịch hẹn không hợp lệ.');
        }

        $appointment->update(['status' => 'confirmed']);

        Notification::create([
            'user_id' => $appointment->patient_id,
            'user_type' => 'patient',
            'title' => 'Xác nhận lịch hẹn',
            'message' => 'Lịch hẹn của bạn với bác sĩ ' . $appointment->doctor->name .
            ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y') . ' đã được đồng ý.',
        ]);

        if($appointment->doctor && $appointment->doctor->user) {
            Notification::create([
                'user_id' => $appointment->doctor->user->id,
                'user_type' => 'doctor',
                'title' => 'Lịch hẹn đã được xác nhận',
                'message' => 'Bạn đã xác nhận lịch hẹn với bệnh nhân ' . $appointment->patient->name .
                ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y'),
            ]);
        }

        return back()->with('success', 'Đã xác nhận lịch hẹn.');
    }


    public function cancel(Appointment $appointment)
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Không thể hủy lịch hẹn này.');
        }

        $appointment->update(['status' => 'cancelled']);

        Notification::create([
            'user_id' => $appointment->patient_id,
            'user_type' => 'patient',
            'title' => 'Lịch hẹn bị hủy',
            'message' => 'Lịch hẹn với bác sĩ ' . $appointment->doctor->name .
            ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y') . ' đã bị từ chối.',
        ]);

        if($appointment->doctor && $appointment->doctor->user) {
            Notification::create([
                'user_id' => $appointment->doctor->user->id,
                'user_type' => 'doctor',
                'title' => 'Lịch hẹn bị hủy',
                'message' => 'Bạn đã hủy lịch hẹn với bệnh nhân ' . $appointment->patient->name .
                ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y'),
            ]);
        }

        return back()->with('success', 'Đã hủy lịch hẹn.');
    }

}
