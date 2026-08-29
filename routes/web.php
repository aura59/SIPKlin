<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

// Login
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.process');

// Profile
Route::get('/admin/profile', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth')->name('admin.profile');
Route::put('/admin/profile', [App\Http\Controllers\ProfileController::class, 'update'])->middleware('auth')->name('admin.profile.update');

// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Dashboard Admin
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('auth')->name('admin.dashboard');

// Dashboard Dokter
Route::get('/dokter/dashboard', [App\Http\Controllers\AdminController::class, 'doctorDashboard'])->middleware('auth')->name('doctor.dashboard');
