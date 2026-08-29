<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

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
