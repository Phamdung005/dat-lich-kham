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

        $notifications = Notification::where('user_id', $user->id)
            ->where('user_type', $user->role) 
            ->latest()
            ->get();
        Notification::where('user_id', $user->id)
            ->where('user_type', $user->role)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($user->role === 'doctor') {
            return view('doctor.notifications.index', compact('notifications'));
        } else {
            return view('patient.notifications.index', compact('notifications'));
        }
    }
    public function doctorNotifications()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
            ->where('user_type', 'doctor')
            ->latest()
            ->get();

        Notification::where('user_id', $user->id)
            ->where('user_type', 'doctor')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('user_type', $user->role)
            ->where('is_read', false)
            ->count();
        return view('doctor.notifications.index', compact('notifications', 'user', 'unreadCount'));
    }

    public function destroy($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $notification->delete();

        return redirect()->route('patient.notifications')->with('success', 'Xóa thông báo thành công.');
    }

    public function destroyAll()
    {
        Notification::where('user_id', auth()->id())->delete();

        return redirect()->route('patient.notifications')->with('success', 'Đã xóa tất cả thông báo.');
    }
    public function deleteDoctorNotification($id) {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('user_type', 'doctor')
            ->firstOrFail();
        $notification->delete();

        return redirect()->route('doctor.notificationdr')->with('success', 'Xóa thông báo thành công.');
    }
    public function deleteAllDoctorNotifications()
    {
        Notification::where('user_id', auth()->id())
            ->where('user_type', 'doctor')
            ->delete();

        return redirect()->route('doctor.notificationdr')->with('success', 'Đã xóa tất cả thông báo.');
    }

}
