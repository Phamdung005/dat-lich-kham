<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;

class NotifyUpcomingAppointments extends Command
{
    protected $signature = 'appointments:notify-upcoming';
    protected $description = 'Gửi thông báo khi còn 30 phút nữa đến lịch hẹn đã xác nhận';

    public function handle()
    {
        $now = now();
        $targetTime = $now->copy()->addMinutes(30)->format('Y-m-d H:i');

        // Lấy các lịch hẹn đã xác nhận và trùng thời điểm bắt đầu trong 30 phút nữa
        $appointments = Appointment::where('status', 'confirmed')
            ->whereRaw("DATE_FORMAT(appointment_time, '%Y-%m-%d %H:%i') = ?", [$targetTime])
            ->get();

        foreach ($appointments as $appointment) {
            Notification::create([
                'user_id' => $appointment->patient_id,
                'title' => '⏰ Sắp đến giờ khám!',
                'message' => 'Chỉ còn 30 phút nữa bạn sẽ khám với bác sĩ ' . $appointment->doctor->name .
                    ' lúc ' . $appointment->appointment_time->format('H:i d/m/Y'),
            ]);
        }

        $this->info('✅ Đã gửi thông báo cho các lịch hẹn sắp đến.');
    }
}
