<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\ControlScheduleHistory;
use Illuminate\Http\Request;

class VisitHistoryController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user();
        $doctorId = null;

        // Jika login sebagai dokter, batasi riwayat sesuai dokter tersebut.
        if ($user->role === 'dokter') {
            $doctor = $user->dokter;

            if (!$doctor) {
                abort(403, 'Data dokter tidak ditemukan.');
            }

            $doctorId = $doctor->id;
        }

        $query = Registration::with([
            'patient' => fn ($patientQuery) => $patientQuery->withTrashed(),
            'doctorSchedule.doctor.department',
            'queue',
            'medicalRecord'
        ])
        ->where('status', 'selesai')
        ->when($doctorId, function ($query) use ($doctorId) {
            $query->whereHas('doctorSchedule', function ($scheduleQuery) use ($doctorId) {
                $scheduleQuery->where('doctor_id', $doctorId);
            });
        });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->withTrashed()
                        ->where(function ($patientDetailsQuery) use ($search) {
                            $patientDetailsQuery->where('nama', 'like', "%{$search}%")
                                ->orWhere('no_rm', 'like', "%{$search}%");
                        });
                })
                ->orWhereHas('doctorSchedule.doctor', function ($doctorQuery) use ($search) {
                    $doctorQuery->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('doctorSchedule.doctor.department', function ($departmentQuery) use ($search) {
                    $departmentQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $registrations = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.visit-history.index', compact(
            'registrations',
            'search'
        ));
    }

    
    public function show($id)
    {
        $user = auth()->user();
        $doctorId = null;

        // Jika login sebagai dokter, batasi detail kunjungan sesuai dokter tersebut.
        if ($user->role === 'dokter') {
            $doctor = $user->dokter;

            if (!$doctor) {
                abort(403, 'Data dokter tidak ditemukan.');
            }

            $doctorId = $doctor->id;
        }

        $registration = Registration::with([
            'patient' => fn ($patientQuery) => $patientQuery->withTrashed(),
            'doctorSchedule.doctor.department',
            'queue',
            'medicalRecord'
        ])
        ->where('status', 'selesai')
        ->when($doctorId, function ($query) use ($doctorId) {
            $query->whereHas('doctorSchedule', function ($scheduleQuery) use ($doctorId) {
                $scheduleQuery->where('doctor_id', $doctorId);
            });
        })
        ->findOrFail($id);

        // Mengambil seluruh riwayat perubahan jadwal kontrol.
        $riwayatKontrol = collect();

        if ($registration->medicalRecord) {
            $riwayatKontrol = ControlScheduleHistory::where(
                'medical_record_id',
                $registration->medicalRecord->id
            )
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return view('pages.visit-history.show', compact(
            'registration',
            'riwayatKontrol'
        ));
    }
}