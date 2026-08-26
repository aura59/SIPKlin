<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard Admin
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware('auth')
    ->name('admin.dashboard');

// Dashboard Dokter
Route::get('/dokter/dashboard', [DashboardController::class, 'dokter'])
    ->middleware('auth')
    ->name('dokter.dashboard');