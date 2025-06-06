<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    //
    public function create(Request $request) {
        $doctorId = $request->query('doctor_id'); 
        $doctors = Doctor::all();
        return view('appointments.create', compact('doctors', 'doctorId'));
    }

    public function store(Request $request) {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id', 
            'appointment_time' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Đặt lịch thành công!');
    }
    public function index() {
    $appointments = Appointment::where('patient_id', auth()->id())
                    ->with('doctor.specialty')
                    ->orderBy('appointment_time', 'desc')
                    ->get();

    return view('appointments.index', compact('appointments'));
    }

}
