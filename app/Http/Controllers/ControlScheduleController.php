<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\ControlScheduleHistory;
use Carbon\Carbon;

class ControlScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
        ->where('perlu_kontrol', true)
        ->whereNotNull('tanggal_kontrol');

        if ($search) {
            $query->whereHas('registration', function ($registrationQuery) use ($search) {
                $registrationQuery->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('nama', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
                })
                ->orWhereHas('doctorSchedule.doctor', function ($doctorQuery) use ($search) {
                    $doctorQuery->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('doctorSchedule.doctor.department', function ($departmentQuery) use ($search) {
                    $departmentQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $jadwalKontrol = $query
            ->orderBy('tanggal_kontrol', 'asc')
            ->get();

        return view('pages.control-schedules.index', compact('jadwalKontrol'));
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'tanggal_kontrol_baru' =>'required|date|after:today',
            'catatan_kontrol_baru' =>'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $id) {
            $medicalRecord = MedicalRecord::lockForUpdate()->findOrFail($id);

            if (! 
            $medicalRecord->perlu_kontrol || !
            $medicalRecord->tanggal_kontrol) {
                throw ValidationException::withMessages([
                    'tanggal_kontrol_baru' => 'Jadwal kontrol tidak ditemukan.',
                ]);
            }

            if (!
            Carbon::parse($medicalRecord->tanggal_kontrol)->isBefore(today())) {
                throw ValidationException::withMessages([
                    'tanggal_kontrol_baru' => 'Hanya jadwal kontrol terlewat yang bisa dijadwalkan ulang.',
                ]);
            }

            $catatanBaru = $request->catatan_kontrol_baru ??
            $medicalRecord->catatan_kontrol;

            ControlScheduleHistory::create([
                'medical_record_id' => $medicalRecord->id,
                'tanggal_kontrol_lama' => $medicalRecord->tanggal_kontrol,
                'catatan_kontrol_lama' => $medicalRecord->catatan_kontrol,
                'tanggal_kontrol_baru' => $request->tanggal_kontrol_baru,
                'catatan_kontrol_baru' => $catatanBaru,
                'user_id' => Auth::id(),
            ]);

            $medicalRecord->update([
                'tanggal_kontrol' =>$request->tanggal_kontrol_baru,
                'catatan_kontrol' => $catatanBaru,
            ]);
        });

        return redirect()->route('control-schedules.index')->with('success', 'Jadwal kontrol berhasil dijadwalkan ulang!.');
    }
}