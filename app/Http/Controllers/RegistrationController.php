<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $departments = Department::all();
        $doctors = Doctor::with('department')->get();
        $doctorschedules = DoctorSchedule::with('doctor.department')->get();
        return view('pages.registration.create', compact('patients', 'departments', 'doctors', 'doctorschedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'tanggal' => 'required|date',
            'catatan' => 'required|string|max:255',
        ]);

        $schedule = DoctorSchedule::findOrFail($request->doctor_schedule_id);

        if ($schedule->doctor_id != $request->doctor_id) {
            return back()->withErrors(['doctor_schedule_id' => 'Jadwal dokter tidak sesuai dengan dokter yang dipilih.'])->withInput();
        }

        Registration::create([
            'patient_id' => $request->patient_id,
            'doctor_schedule_id' => $request->doctor_schedule_id,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('queues.index')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }
}
