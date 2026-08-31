<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalPasien = Patient::count();

        return view('admin.dashboard', compact('totalPasien'));
    }

    // Dashboard Dokter
    public function doctorDashboard()
    {
        $totalPasien = Patient::count();

       return view('doctor.dashboard', compact('totalPasien'));
    }
}