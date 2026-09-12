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
        })->orderBy('created_at', 'asc')->get();

        $selectedDepartment = null;

        if ($request->department_id) {
            $selectedDepartment = $departments->firstWhere(
                'id',
                $request->department_id
            );
        }

        $currentRegistration = $registrations->where('status', 'dipanggil')->first();

        $nextRegistration = $registrations->where('status', 'menunggu')->first();

        return view('pages.queue.index', compact('registrations','departments','selectedDepartment','currentRegistration','nextRegistration','tanggal'
        ));
    }


    public function call($id)
    {
        $registration = Registration::with(['doctorSchedule.doctor'])->findOrFail($id);

        Registration::where('status', 'dipanggil')->update(['status' => 'selesai']);

        $registration->update(['status' => 'dipanggil']);

        return back()->with('success','Antrean berhasil dipanggil.');
    }


    public function finish($id)
    {
        $registration = Registration::findOrFail($id);

        $registration->update(['status' => 'selesai' ]);

        return back()->with('success','Antrean berhasil diselesaikan.');
    }
}