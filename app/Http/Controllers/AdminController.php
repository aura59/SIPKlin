<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Registration;
use App\Models\MedicalRecord;

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
        
        // Data grafik kunjungan pasien per bulan pada tahun berjalan
        $kunjunganPerBulan = Registration::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', now()->year)
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan');

        $grafikKunjungan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $grafikKunjungan[] = (int) ($kunjunganPerBulan[$bulan] ?? 0);
        }

        // Jadwal kontrol pasien hari ini
        $jadwalKontrolHariIni = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
            ->where('perlu_kontrol', true)
            ->whereNotNull('tanggal_kontrol')
            ->whereDate('tanggal_kontrol', today())
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();

        $totalKontrolHariIni = $jadwalKontrolHariIni->count();

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
            'antreanMenunggu',
            'jadwalKontrolHariIni',
            'totalKontrolHariIni',
            'grafikKunjungan'
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

        // Jadwal kontrol pasien hari ini
        $jadwalKontrolHariIni = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
            ->where('perlu_kontrol', true)
            ->whereNotNull('tanggal_kontrol')
            ->whereDate('tanggal_kontrol', today())
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();

        $totalKontrolHariIni = $jadwalKontrolHariIni->count();

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

        return view('doctor.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPendaftaranHariIni',
            'totalAntreanMenunggu',
            'pendaftaranHariIni',
            'antreanMenunggu',
            'jadwalKontrolHariIni',
            'totalKontrolHariIni'
        ));
    }
}