<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class VisitHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue',
            'medicalRecord'
        ])
        ->where('status', 'selesai');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('no_rm', 'like', "%{$search}%");
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
        $registration = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue',
            'medicalRecord'
        ])->findOrFail($id);

        return view('pages.visit-history.show', compact('registration'));
    }
}