<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function create()
    {
        $patients = Patient::all();
        $departments = Department::all();
        $doctors = Doctor::with('department')->get();
        $doctorschedules = DoctorSchedule::with('doctor.department')
            ->orderBy('doctor_id')
            ->orderByRaw("CASE hari
                WHEN 'Senin' THEN 1
                WHEN 'Selasa' THEN 2
                WHEN 'Rabu' THEN 3
                WHEN 'Kamis' THEN 4
                WHEN 'Jumat' THEN 5
                WHEN 'Sabtu' THEN 6
                WHEN 'Minggu' THEN 7
                ELSE 8
            END")
            ->orderBy('jam_mulai')
            ->orderBy('id')
            ->get();

        $registrationCounts = Registration::selectRaw(
            'doctor_schedule_id, tanggal, COUNT(*) as jumlah'
        )
        ->groupBy('doctor_schedule_id', 'tanggal')
        ->get()
        ->mapWithKeys(function ($registration) {
            return [
                $registration->doctor_schedule_id . '_' . $registration->tanggal=> $registration->jumlah
            ];
        });

        $queueNumbers = Queue::whereHas('registration', function ($query) {
            $query->whereDate('tanggal', '>=', today());
        })
        ->with('registration.doctorSchedule.doctor')
        ->get()
        ->groupBy(function ($queue) {
            return $queue->registration->doctorSchedule->doctor->department_id . '_' . $queue->registration->tanggal;
            })->map(function ($queues) {
                return $queues->max('nomor_antrean');
            });

        return view('pages.registration.create', compact(
            'patients',
            'departments',
            'doctors',
            'doctorschedules',
            'registrationCounts',
            'queueNumbers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'catatan' => 'required|string|max:255',
        ], [
            'tanggal.after_or_equal' => 'Tanggal pendaftaran tidak boleh sebelum hari ini.',
        ]);

        $schedule = DoctorSchedule::with('doctor.department')->findOrFail($request->doctor_schedule_id);

        $hariTanggal = \Carbon\Carbon::parse($request->tanggal)->locale('id')->translatedFormat('l');

        if ($hariTanggal !== $schedule->hari) {
            return back()->withErrors([
                    'tanggal' =>'Tanggal yang dipilih tidak sesuai dengan hari jadwal dokter.'
                ])->withInput();
        }

        if ($schedule->doctor_id != $request->doctor_id) {
            return back()->withErrors([
                    'doctor_schedule_id' =>'Jadwal dokter tidak sesuai dengan dokter yang dipilih.'
                ])->withInput();
        }

       $registration = DB::transaction(function () use ($request, $schedule) {
            $department = Department::whereKey($schedule->doctor->department_id)
                ->lockForUpdate()
                ->firstOrFail();

            $jumlahPendaftaran = Registration::where('doctor_schedule_id', $schedule->id)
                ->whereDate('tanggal', $request->tanggal)
                ->count();

            if ($jumlahPendaftaran >= $schedule->kuota) {
                throw ValidationException::withMessages([
                    'doctor_schedule_id' => 'Kuota pendaftaran untuk jadwal ini sudah penuh.'
                ]);
            }

            $registration = Registration::create([
                'patient_id' => $request->patient_id,
                'doctor_schedule_id' => $schedule->id,
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

            Queue::create([
                'registration_id' => $registration->id,
                'nomor_antrean' => $lastQueue ? $lastQueue + 1 : 1,
                'status' => 'menunggu',
            ]);
            return $registration;
        });

        return redirect()->route('registrations.ticket', $registration->id)->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

        public function ticket($id)
    {
        $registration = Registration::with([
            'patient',
            'doctorSchedule.doctor.department',
            'queue',
        ])->findOrFail($id);

        return view('pages.registration.ticket', compact('registration'));
    }
}