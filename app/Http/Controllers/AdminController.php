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
}
