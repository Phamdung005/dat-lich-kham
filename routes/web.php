<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\Patient\PatientDashboardController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home'); 
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    return redirect()->route($role . '.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');
Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard')->middleware('auth');
Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/appointment/create', [\App\Http\Controllers\AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment/store', [\App\Http\Controllers\AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments', [\App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');

    Route::get('/patient/profile', [PatientController::class, 'showProfile'])->name('patient.profile')->middleware('auth');
});

Route::middleware(['auth', 'can:isAdmin'])->prefix('admin')->group(function () {
    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);
    Route::resource('patients', \App\Http\Controllers\Admin\PatientController::class);
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::get('/specialty/{id}/doctors', [PatientController::class, 'viewDoctors'])->name('specialty.doctors');

Route::middleware(['auth', 'isPatient'])->group(function () {
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/profile', [ProfileController::class, 'show'])->name('patient.profile.show');
    Route::put('/patient/profile', [ProfileController::class, 'update'])->name('patient.profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
});

Route::middleware(['auth'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::post('/appointments/{appointment}/confirm', [DoctorController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/cancel', [DoctorController::class, 'cancel'])->name('doctor.appointments.cancel');
});

Route::get('/patient/appointments', [PatientController::class, 'indexAppointments'])->name('patient.appointments')->middleware('auth');

Route::get('/api/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('appointments.available-times');
