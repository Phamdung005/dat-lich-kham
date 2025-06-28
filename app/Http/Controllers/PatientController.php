<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    //
    public function dashboard() {
        $user = auth()->user();
        $specialties = Specialty::with('doctors')->get();
        return view('dashboard.patient', compact('user', 'specialties'));
    }

    public function showProfile(){
        $user = auth()->user();
        return view('patient.profile', compact('user'));
    }

    public function viewDoctors($id) {
        $specialty = Specialty::with('doctors')->findOrFail($id);
        return view('patient.doctors_by_specialty', compact('specialty'));
    }

    public function indexAppointments()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('doctor.specialty')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $slotDisplayMap = [
            '08:00' => '08:00 - 09:30',
            '09:30' => '09:30 - 11:00',
            '11:00' => '11:00 - 12:30',
            '12:30' => '12:30 - 14:00',
            '14:00' => '14:00 - 15:30',
            '15:30' => '15:30 - 17:00',
            '17:00' => '17:00 - 18:30',
        ];

        return view('appointments.index', compact('appointments', 'slotDisplayMap'));
    }

    public function historyapps()
    {
        $user = Auth::user();

        $appointments = Appointment::where('patient_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled']) 
            ->with('doctor.user')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $slotDisplayMap = [
            '08:00' => '08:00 - 09:30',
            '09:30' => '09:30 - 11:00',
            '11:00' => '11:00 - 12:30',
            '12:30' => '12:30 - 14:00',
            '14:00' => '14:00 - 15:30',
            '15:30' => '15:30 - 17:00',
            '17:00' => '17:00 - 18:30',
        ];

        return view('patient.history', compact('appointments', 'slotDisplayMap', 'user'));
    }
    public function deleteHistory($id) {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', auth()->id())
            ->whereIn('status', ['completed', 'cancelled'])
            ->firstOrFail();

        $appointment->delete();
        return redirect()->route('patient.appointments.history')->with('sucess', 'Xóa lịch sử thành công.');
    }

    public function deleteAllHistory() {
        Appointment::where('patient_id', auth()->id())
            ->whereIn('status', ['completed', 'cancelled'])
            ->delete();

        return redirect()->route('patient.appointments.history')->with('success', 'Đã xóa toàn bộ lịch sử khám bệnh');
    }

}
