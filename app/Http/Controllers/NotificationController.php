<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Lấy thông báo của user hiện tại (phải có quan hệ notifications trong User.php)
        $notifications = Auth::user()->notifications()->latest()->get();

        return view('notifications.index', compact('notifications'));


        $notifications = Auth::user()->notifications()->latest()->get();
    return view('notifications.index', compact('notifications'));
    }



}
