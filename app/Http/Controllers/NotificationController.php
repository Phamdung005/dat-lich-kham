<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Lấy thông báo theo user
        $notifications = Notification::where('user_id', $user->id)->latest()->get();

        // Đánh dấu thông báo là đã đọc
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('patient.notifications.index', compact('notifications'));
    }
}
