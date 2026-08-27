<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Dashboard Dokter
    public function doctorDashboard()
    {
        return view('doctor.dashboard');
    }
}