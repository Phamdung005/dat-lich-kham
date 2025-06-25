<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\NotifyUpcomingAppointments;

class Kernel extends ConsoleKernel
{
    /**
     * Đăng ký các command tùy chỉnh
     */
    protected $commands = [
        NotifyUpcomingAppointments::class,
    ];

    /**
     * Lên lịch chạy các command
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('appointments:notify-upcoming')->everyMinute();
    }

    /**
     * Tải các command định nghĩa trong thư mục Commands
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
