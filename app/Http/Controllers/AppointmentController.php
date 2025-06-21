<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;


class AppointmentController extends Controller
{
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


    public function edit(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string'
        ]);

        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        $appointment->update([
            'appointment_time' => $datetime,
            'notes' => $request->notes
        ]);
        return redirect()->route('appointments.index')->with('success', 'Đã cập nhật lịch hẹn.');

    }
    
    public function destroy(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Đã xoá lịch hẹn.');
    }

}
