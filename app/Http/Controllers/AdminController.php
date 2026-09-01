<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalPasien = Patient::count();
        $totalDokter = Doctor::count();
        $totalPendaftaranHariIni = 0;
        $totalAntreanMenunggu = 0;

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPendaftaranHariIni',
            'totalAntreanMenunggu'
        ));
    }

    // Dashboard Dokter
    public function doctorDashboard()
    {
        $totalPasien = Patient::count();
        $totalDokter = Doctor::count();
        $totalPendaftaranHariIni = 0;
        $totalAntreanMenunggu = 0;

        return view('doctor.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPendaftaranHariIni',
            'totalAntreanMenunggu'
        ));
    }
}