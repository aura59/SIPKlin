<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Registration;
use App\Models\MedicalRecord;
use Carbon\Carbon;

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
        
        // Data grafik kunjungan pasien
        $kunjunganPerBulan = Registration::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', now()->year)
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan');

        $grafikKunjungan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $grafikKunjungan[] = (int) ($kunjunganPerBulan[$bulan] ?? 0);
        }

        // Pengingat jadwal kontrol pasien
        $hariIni = Carbon::today();
        $jadwalKontrolTerlewat = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
            ->where('perlu_kontrol', true)
            ->whereNotNull('tanggal_kontrol')
            ->whereDate('tanggal_kontrol', '<', $hariIni)
            ->orderBy('tanggal_kontrol', 'desc')
            ->get();

        $totalKontrolTerlewat = $jadwalKontrolTerlewat->count();

        // Jadwal kontrol hari ini
        $jadwalKontrolHariIni = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
            ->where('perlu_kontrol', true)
            ->whereNotNull('tanggal_kontrol')
            ->whereDate('tanggal_kontrol', $hariIni)
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();

        $totalKontrolHariIni = $jadwalKontrolHariIni->count();

        // Jadwal kontrol yang mendekati
        $jadwalKontrolMendatang = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
            ->where('perlu_kontrol', true)
            ->whereNotNull('tanggal_kontrol')
            ->whereDate('tanggal_kontrol', '>', $hariIni)
            ->whereDate('tanggal_kontrol', '<=', $hariIni->copy()->addDays(3))
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();

        $totalKontrolMendatang = $jadwalKontrolMendatang->count();
        $totalPengingatKontrol =
            $totalKontrolTerlewat
            + $totalKontrolHariIni
            + $totalKontrolMendatang;
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
            'jadwalKontrolTerlewat',
            'totalKontrolTerlewat',
            'jadwalKontrolMendatang',
            'totalKontrolMendatang',
            'totalPengingatKontrol',
            'grafikKunjungan'
        ));
    }

    // Dashboard Dokter
    public function doctorDashboard()
    {
        $user = auth()->user();
        $doctor = $user->dokter;

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        $doctorId = $doctor->id;

        // Total pasien unik yang pernah terdaftar pada dokter ini.
        $totalPasien = Registration::whereHas('doctorSchedule', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
            ->distinct('patient_id')
            ->count('patient_id');

        $totalDokter = Doctor::count();

        // Pendaftaran hari ini khusus dokter yang sedang login.
        $pendaftaranHariIni = Registration::with(
            'patient',
            'doctorSchedule.doctor.department'
        )
            ->whereDate('tanggal', today())
            ->whereHas('doctorSchedule', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $totalPendaftaranHariIni = $pendaftaranHariIni->count();

        // Antrean menunggu khusus dokter yang sedang login.
        $totalAntreanMenunggu = Registration::where('status', 'menunggu')
            ->whereDate('tanggal', today())
            ->whereHas('doctorSchedule', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->count();

        // Grafik kunjungan khusus dokter yang sedang login.
        $kunjunganPerBulan = Registration::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', now()->year)
            ->whereHas('doctorSchedule', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan');

        $grafikKunjungan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $grafikKunjungan[] = (int) ($kunjunganPerBulan[$bulan] ?? 0);
        }

        // Pengingat jadwal kontrol khusus pasien dokter ini.
        $hariIni = Carbon::today();
        $queryKontrol = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
            ->whereHas('registration.doctorSchedule', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->where('perlu_kontrol', true)
            ->whereNotNull('tanggal_kontrol');

        // Jadwal kontrol yang terlewat.
        $jadwalKontrolTerlewat = (clone $queryKontrol)
            ->whereDate('tanggal_kontrol', '<', $hariIni)
            ->orderBy('tanggal_kontrol', 'desc')
            ->get();
        $totalKontrolTerlewat = $jadwalKontrolTerlewat->count();

        // Jadwal kontrol hari ini.
        $jadwalKontrolHariIni = (clone $queryKontrol)
            ->whereDate('tanggal_kontrol', $hariIni)
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();
        $totalKontrolHariIni = $jadwalKontrolHariIni->count();

        // Jadwal kontrol tiga hari ke depan.
        $jadwalKontrolMendatang = (clone $queryKontrol)
            ->whereDate('tanggal_kontrol', '>', $hariIni)
            ->whereDate('tanggal_kontrol', '<=', $hariIni->copy()->addDays(3))
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();
        $totalKontrolMendatang = $jadwalKontrolMendatang->count();

        $totalPengingatKontrol =
            $totalKontrolTerlewat
            + $totalKontrolHariIni
            + $totalKontrolMendatang;

        // Ringkasan antrean berdasarkan poli dokter.
        $antreanMenunggu = Registration::with(
            'doctorSchedule.doctor.department'
        )
            ->where('status', 'menunggu')
            ->whereDate('tanggal', today())
            ->whereHas('doctorSchedule', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
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
            'totalKontrolHariIni',
            'jadwalKontrolTerlewat',
            'totalKontrolTerlewat',
            'jadwalKontrolMendatang',
            'totalKontrolMendatang',
            'totalPengingatKontrol',
            'grafikKunjungan'
        ));
    }
}