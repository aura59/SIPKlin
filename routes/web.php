<?php

use Illuminate\Support\Facades\Route;

// login
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.process');

// profile
Route::get('/admin/profile', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth')->name('admin.profile');
Route::put('/admin/profile', [App\Http\Controllers\ProfileController::class, 'update'])->middleware('auth')->name('admin.profile.update');

// dokter profile
Route::get('/dokter/profile', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth')->name('doctor.profile');
Route::put('/dokter/profile', [App\Http\Controllers\ProfileController::class, 'update'])->middleware('auth')->name('doctor.profile.update');

// logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// dshboard admin
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('auth')->name('admin.dashboard');

// dashboard dokter
Route::get('/dokter/dashboard', [App\Http\Controllers\AdminController::class, 'doctorDashboard'])->middleware('auth')->name('doctor.dashboard');


// pasien
Route::middleware('auth')->group(function () {

Route::resource('/patients', App\Http\Controllers\PatientController::class);
});

// dokter
Route::middleware('auth')->group(function () {

Route::resource('/doctors', App\Http\Controllers\DoctorController::class);
});

// poli
Route::middleware('auth')->group(function () {
Route::resource('/departments', App\Http\Controllers\DepartmentController::class);
});
