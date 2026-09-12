<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class VisitHistoryController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue',
            'medicalRecord'
        ])
        ->where('status', 'selesai')
        ->orderBy('tanggal', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('pages.visit-history.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue',
            'medicalRecord'
        ])->findOrFail($id);

        return view('pages.visit-history.show', compact('registration'));
    }
}