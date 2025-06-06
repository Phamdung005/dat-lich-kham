<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Specialty;

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

}
