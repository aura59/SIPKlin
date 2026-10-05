<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Registration;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MedicalRecordController extends Controller
{
    public function create()
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $registrations = Registration::with([
            'patient',
            'doctorSchedule.doctor.department'
        ])
        ->whereDate('tanggal', today())
        ->whereHas('doctorSchedule', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })
        ->where('status', 'dipanggil')
        ->doesntHave('medicalRecord')
        ->orderBy('created_at', 'asc')
        ->get();

        return view('pages.medical-record.create', compact('registrations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'keluhan' => 'required|string|max:500',
            'diagnosis' => 'required|string|max:500',
            'tindakan' => 'required|string|max:500',
        ]);

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        $registration = Registration::with('queue', 'doctorSchedule')
            ->findOrFail($request->registration_id);

        if ($registration->doctorSchedule->doctor_id !== $doctor->id) {
            abort(403);
        }

        if ($registration->status !== 'dipanggil') {
            return back()->withErrors([
                'registration_id' => 'Rekam medis hanya bisa dibuat saat pasien sedang dipanggil.'
            ])->withInput();
        }

        DB::transaction(function () use ($request, $registration) {
            $registration = Registration::with('queue')
                ->lockForUpdate()
                ->findOrFail($registration->id);

            if ($registration->medicalRecord()->exists()) {
                throw ValidationException::withMessages([
                    'registration_id' => 'Rekam medis untuk kunjungan ini sudah dibuat.'
                ]);
            }

            if ($registration->status !== 'dipanggil') {
                throw ValidationException::withMessages([
                    'registration_id' => 'Rekam medis hanya bisa dibuat saat pasien sedang dipanggil.'
                ]);
            }

            MedicalRecord::create([
                'registration_id' => $registration->id,
                'keluhan' => $request->keluhan,
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
            ]);

            $registration->update(['status' => 'selesai']);
            $registration->queue?->update(['status' => 'selesai']);
        });

        return redirect()->route('queues.index')->with('success', 'Rekam medis berhasil disimpan.');
    }
}