<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Registration;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalPasien = Patient::count();
        $totalDokter = Doctor::count();
        $pendaftaranHariIni = Registration::with('patient', 'doctorSchedule.doctor.department')->whereDate('tanggal', today())->orderBy('created_at', 'asc')->get();
        $totalPendaftaranHariIni = $pendaftaranHariIni->count();
        $totalAntreanMenunggu = Registration::where('status', 'menunggu')->whereDate('tanggal', today())->count();

        $antreanMenunggu = Registration::with('doctorSchedule.doctor.department')
            ->where('status', 'menunggu')
            ->whereDate('tanggal', today())
            ->get()
            ->groupBy(function ($registration) {
                return $registration->doctorSchedule->doctor->department->name;
            })
            ->map(function ($registrations) {
                return $registrations->count();
            });

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPendaftaranHariIni',
            'totalAntreanMenunggu',
            'pendaftaranHariIni',
            'antreanMenunggu'
        ));
    }

    // Dashboard Dokter
    public function doctorDashboard()
    {
       $totalPasien = Patient::count();
        $totalDokter = Doctor::count();
        $pendaftaranHariIni = Registration::with('patient', 'doctorSchedule.doctor.department')->whereDate('tanggal', today())->orderBy('created_at', 'asc')->get();
        $totalPendaftaranHariIni = $pendaftaranHariIni->count();
        $totalAntreanMenunggu = Registration::where('status', 'menunggu')->whereDate('tanggal', today())->count();

        $antreanMenunggu = Registration::with('doctorSchedule.doctor.department')
            ->where('status', 'menunggu')
            ->whereDate('tanggal', today())
            ->get()
            ->groupBy(function ($registration) {
                return $registration->doctorSchedule->doctor->department->name;
            })
            ->map(function ($registrations) {
                return $registrations->count();
            });

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPendaftaranHariIni',
            'totalAntreanMenunggu',
            'pendaftaranHariIni',
            'antreanMenunggu'
        ));
    }
}