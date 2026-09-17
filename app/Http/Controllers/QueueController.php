<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Registration;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $tanggal = $request->tanggal ?? now('Asia/Jakarta')->format('Y-m-d');
        $registrations = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue'
        ])
        ->whereDate('tanggal', $tanggal)
        ->when($request->department_id, function ($query) use ($request) {
            $query->whereHas('doctorSchedule.doctor', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        })
        ->orderBy('created_at', 'asc')
        ->paginate(10)
        ->withQueryString();

        $selectedDepartment = null;

        if ($request->department_id) {
            $selectedDepartment = $departments->firstWhere(
                'id',
                $request->department_id
            );
        }

        $currentRegistration = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue'
        ])
        ->whereDate('tanggal', $tanggal)
        ->where('status', 'dipanggil')
        ->when($request->department_id, function ($query) use ($request) {
            $query->whereHas('doctorSchedule.doctor', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        })
        ->orderBy('updated_at', 'desc')
        ->first();

        $nextRegistration = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue'
        ])
        ->whereDate('tanggal', $tanggal)
        ->where('status', 'menunggu')
        ->when($request->department_id, function ($query) use ($request) {
            $query->whereHas('doctorSchedule.doctor', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        })
        ->orderBy('created_at', 'asc')
        ->first();

        return view('pages.queue.index', compact(
            'registrations',
            'departments',
            'selectedDepartment',
            'currentRegistration',
            'nextRegistration',
            'tanggal'
        ));
    }

    public function call($id)
    {
        $registration = Registration::with([
            'doctorSchedule.doctor.department',
            'queue'
        ])->findOrFail($id);

        $departmentId = $registration->doctorSchedule->doctor->department_id;
        $tanggal = $registration->tanggal;

        Registration::where('status', 'dipanggil')
            ->whereDate('tanggal', $tanggal)
            ->whereHas('doctorSchedule.doctor', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->update([
                'status' => 'selesai'
            ]);

        $registration->update([
            'status' => 'dipanggil'
        ]);

        if ($registration->queue) {
            $registration->queue->update([
                'status' => 'dipanggil'
            ]);
        }

        return back()->with('success', 'Antrean berhasil dipanggil.');
    }

    public function finish($id)
    {
        $registration = Registration::with('queue')->findOrFail($id);

        if (!$registration->medicalRecord()->exists()) {
                return back()->withErrors(['registration' => 'Pasien harus memiliki rekam medis sebelum antrean diselesaikan.'
            ]);
        }
        $registration->update([
            'status' => 'selesai'
        ]);

        if ($registration->queue) {
            $registration->queue->update([
                'status' => 'selesai'
            ]);
        }

        return back()->with('success', 'Antrean berhasil diselesaikan.');
    }
}