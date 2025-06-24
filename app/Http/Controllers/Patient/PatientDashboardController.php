<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Specialty;
use App\Models\Notification;

class PatientDashboardController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $specialtyId = $request->input('specialty_id');

        $allSpecialties = Specialty::all();

        $specialties = Specialty::with(['doctors' => function ($query) use ($keyword) {
            if ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            }
        }])
        ->when($specialtyId, function ($query) use ($specialtyId) {
            $query->where('id', $specialtyId);
        })
        ->get();

        $user = auth()->user();
        $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

        return view('dashboard.patient', compact('user', 'specialties', 'allSpecialties', 'unreadCount'));
    }
}
