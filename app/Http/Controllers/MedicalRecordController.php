<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Registration;

class MedicalRecordController extends Controller
{
    public function create()
    {
        $registrations = Registration::with([
            'patient',
            'doctorSchedule.doctor.department'
        ])
        ->whereDate('tanggal', today())
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
            'tindakan' => 'nullable|string|max:500',
            'catatan' => 'nullable|string|max:500',
        ]);

        $registration = Registration::findOrFail(
            $request->registration_id
        );

        if ($registration->medicalRecord()->exists()) {
            return back()
                ->withErrors([
                    'registration_id' =>
                        'Rekam medis untuk kunjungan ini sudah dibuat.'
                ])
                ->withInput();
        }

        MedicalRecord::create([
            'registration_id' => $request->registration_id,
            'keluhan' => $request->keluhan,
            'diagnosis' => $request->diagnosis,
            'tindakan' => $request->tindakan,
            'catatan' => $request->catatan,
        ]);

        $registration->update([
            'status' => 'selesai'
        ]);

        return redirect()
            ->route('queues.index')
            ->with('success', 'Rekam medis berhasil disimpan.');
    }
}