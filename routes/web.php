<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;

// Login
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.process');

// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Dashboard Admin
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('auth')->name('admin.dashboard');

// Dashboard Dokter
Route::get('/dokter/dashboard', [App\Http\Controllers\AdminController::class, 'doctorDashboard'])->middleware('auth')->name('dokter.dashboard');