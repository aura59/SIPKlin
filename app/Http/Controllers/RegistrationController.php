<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Queue;

class RegistrationController extends Controller
{
    public function create()
    {
        $patients = Patient::all();
        $departments = Department::all();
        $doctors = Doctor::with('department')->get();
        $doctorschedules = DoctorSchedule::with('doctor.department')->get();

        $registrationCounts = Registration::selectRaw(
            'doctor_schedule_id, tanggal, COUNT(*) as jumlah'
        )
        ->groupBy('doctor_schedule_id', 'tanggal')
        ->get()
        ->mapWithKeys(function ($registration) {
            return [
                $registration->doctor_schedule_id . '_' . $registration->tanggal
                    => $registration->jumlah
            ];
        });

        return view('pages.registration.create', compact(
            'patients',
            'departments',
            'doctors',
            'doctorschedules',
            'registrationCounts'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'tanggal' => 'required|date',
            'catatan' => 'required|string|max:255',
        ]);

        $schedule = DoctorSchedule::with('doctor.department')->findOrFail($request->doctor_schedule_id);

        if ($schedule->doctor_id != $request->doctor_id) {
            return back()->withErrors([
                    'doctor_schedule_id' =>'Jadwal dokter tidak sesuai dengan dokter yang dipilih.'
                ])->withInput();
        }

        $jumlahPendaftaran = Registration::where('doctor_schedule_id',$request->doctor_schedule_id)
        ->whereDate('tanggal', $request->tanggal)
        ->count();

        if ($jumlahPendaftaran >= $schedule->kuota) {
            return back()->withErrors([
                    'doctor_schedule_id' =>'Kuota pendaftaran untuk jadwal ini sudah penuh.'
                ])->withInput();
        }

        $department = $schedule->doctor->department;

        $kodePoli = chr(64 + $department->id);

        $registration = Registration::create([
            'patient_id' => $request->patient_id,
            'doctor_schedule_id' => $request->doctor_schedule_id,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'status' => 'menunggu',
        ]);

        $lastQueue = Queue::whereHas('registration.doctorSchedule.doctor', function ($query) use ($department) {
            $query->where('department_id', $department->id);
        })
        ->whereHas('registration', function ($query) use ($request) {
            $query->whereDate('tanggal', $request->tanggal);
        })
        ->max('nomor_antrean');

        $nextQueueNumber = $lastQueue ? $lastQueue + 1 : 1;

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => $nextQueueNumber,
            'status' => 'menunggu',
        ]);

        return redirect()->route('queues.index')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }
}