<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Admin\AdminDoctorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DoctorAppointmentController;

// ---------------------- Auth routes ----------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------- Home route ----------------------
Route::get('/', function () {
    return view('home'); 
});

// ---------------------- Role redirect dashboard ----------------------
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    return redirect()->route($role . '.dashboard');
})->middleware('auth')->name('dashboard');

// ---------------------- Dashboard for each role ----------------------
Route::get('/admin/dashboard', [AdminDoctorController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard')->middleware('auth');
Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard')->middleware('auth');

// ---------------------- Appointment routes ----------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/api/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('appointments.available-times');
});

Route::middleware(['auth', 'isPatient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('patient.profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('patient.profile.update');

    Route::get('/appointments', [PatientController::class, 'indexAppointments'])->name('patient.appointments');
    Route::get('/appointments/history', [PatientController::class, 'historyapps'])->name('patient.appointments.history');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('patient.appointments.cancel');
    Route::delete('/appointments/history/{id}', [PatientController::class, 'deleteHistory'])->name('patient.appointments.history.delete');
    Route::delete('/appointments/history', [PatientController::class, 'deleteAllHistory'])->name('patient.appointments.history.deleteAll');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('patient.notifications');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('patient.notifications.delete');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('patient.notifications.deleteAll');
});



// ---------------------- Doctor routes ----------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/profileDoctor', [DoctorController::class, 'showProfile'])->name('doctor.profileDoctor.show');
    Route::put('/doctor/profile', [DoctorController::class, 'updateProfile'])->name('doctor.profileDoctor.update');
});

Route::middleware(['auth', 'isDoctor'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::post('/appointments/{appointment}/confirm', [DoctorAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/cancel', [DoctorAppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{appointment}/assign-room', [DoctorController::class, 'assignRoom'])->name('appointments.assignRoom');

    Route::get('/appointments', [DoctorController::class, 'appointmentDr'])->name('doctor.appointmentdr');
    Route::post('/appointments/{appointment}/complete', [DoctorController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/update-room', [DoctorController::class, 'updateRoom'])->name('appointments.updateRoom');
    Route::get('/history', [DoctorController::class, 'history'])->name('doctor.historyapp');
    Route::delete('/history/{id}', [DoctorController::class, 'deleteDoctorHistory'])->name(('doctor.history.delete'));
    Route::delete('/history', [DoctorController::class, 'deleteAllDoctorHistory'])->name('doctor.history.deleteAll');

    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'doctorNotifications'])->name('doctor.notificationdr');
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteDoctorNotification'])->name('doctor.notifications.delete');
    Route::delete('/notifications', [NotificationController::class, 'deleteAllDoctorNotifications'])->name('doctor.notifications.deleteAll');
});


// ---------------------- Public specialty route ----------------------
Route::get('/specialty/{id}/doctors', [PatientController::class, 'viewDoctors'])->name('specialty.doctors');

// ---------------------- Admin routes ----------------------
Route::middleware(['auth', 'can:isAdmin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminDoctorController::class, 'index'])->name('admin.dashboard');

    Route::put('doctors/{id}', [AdminDoctorController::class, 'update'])->name('admin.doctor.update');
    Route::delete('doctors/{id}', [AdminDoctorController::class, 'destroy'])->name('admin.doctor.delete');

    Route::get('doctors/create', [AdminDoctorController::class, 'create'])->name('admin.doctors.create');
    Route::post('doctors', [AdminDoctorController::class, 'store'])->name('admin.doctors.store');
    Route::get('doctors/{id}/edit', [AdminDoctorController::class, 'edit'])->name('admin.doctors.edit');
});
