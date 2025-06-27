<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Notification;

class DoctorAppointmentController extends Controller
    {
        public function confirm(Appointment $appointment)
        {
            // Kiểm tra bác sĩ là chủ nhân lịch hẹn
            if ($appointment->doctor_id !== auth()->id()) {
                abort(403);
            }

            // Chỉ cho phép xác nhận nếu đang ở trạng thái 'pending'
            if ($appointment->status !== 'pending') {
                return back()->with('error', 'Lịch hẹn không hợp lệ.');
            }

            // Cập nhật trạng thái
            $appointment->update(['status' => 'confirmed']);

            // Tạo thông báo cho bệnh nhân
            Notification::create([
                'user_id' => $appointment->patient_id,
                'title' => 'Xác nhận lịch hẹn',
                'message' => 'Lịch hẹn của bạn với bác sĩ ' . $appointment->doctor->name .
                ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y') . ' đã được đồng ý.',
            ]);


            return back()->with('success', 'Đã xác nhận lịch hẹn.');
        }

        public function cancel(Appointment $appointment)
        {
            if ($appointment->doctor_id !== auth()->id()) {
                abort(403);
            }

            if (!in_array($appointment->status, ['pending', 'confirmed'])) {
                return back()->with('error', 'Không thể hủy lịch hẹn này.');
            }

            $appointment->update(['status' => 'cancelled']);

            // Thêm thông báo cho bệnh nhân
            Notification::create([
                'user_id' => $appointment->patient_id,
                'title' => 'Lịch hẹn bị hủy',
                'message' => 'Lịch hẹn với bác sĩ ' . $appointment->doctor->name .
                ' vào lúc ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i d/m/Y') . ' đã bị từ chối.',
            ]);

            return back()->with('success', 'Đã hủy lịch hẹn.');
        }
}
