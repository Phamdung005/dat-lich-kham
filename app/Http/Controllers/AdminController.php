<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialty;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $keyword = $request->input('keyword');
        $specialty_id = $request->input('specialty_id');

        $query = Doctor::with('specialty');

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($specialty_id) {
            $query->where('specialty_id', $specialty_id);
        }

        $doctors = $query->get();
        $allSpecialties = Specialty::all();

        return view('dashboard.admin', compact('doctors', 'allSpecialties'));
    }
    public function statistics()
    {
        $totalDoctors = \App\Models\User::where('role', 'doctor')->count();
        $totalPatients = \App\Models\User::where('role', 'patient')->count();

        $totalAppointments = \App\Models\Appointment::count();

        $today = \Carbon\Carbon::today();
        $thisWeek = \Carbon\Carbon::now()->subDays(7);
        $thisMonth = \Carbon\Carbon::now()->startOfMonth();

        $appointmentsToday = \App\Models\Appointment::whereDate('appointment_time', $today)->count();
        $appointmentsThisWeek = \App\Models\Appointment::whereDate('appointment_time', '>=', $thisWeek)->count();
        $appointmentsThisMonth = \App\Models\Appointment::whereDate('appointment_time', '>=', $thisMonth)->count();

        $totalRooms = \App\Models\Room::count();

        return view('admin.statistics', compact(
            'totalDoctors',
            'totalPatients',
            'totalAppointments',
            'appointmentsToday',
            'appointmentsThisWeek',
            'appointmentsThisMonth',
            'totalRooms'  
        ));
    }


}
