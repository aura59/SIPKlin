<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctorschedules = DoctorSchedule::with('doctor.department')->get();
        return view('pages.doctorSchedule.index', compact('doctorschedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::with('department')->get();

        return view('pages.doctorSchedule.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        DoctorSchedule::create([
            'doctor_id' => $request->doctor_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('doctorschedules.index')->with('success', 'Data jadwal dokter berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctorschedule = DoctorSchedule::with('doctor.department')->findOrFail($id);

        return view('pages.doctorSchedule.show', compact('doctorschedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctorschedule = DoctorSchedule::findOrFail($id);
        $doctors = Doctor::with('department')->get();

        return view('pages.doctorSchedule.edit', compact('doctorschedule', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        $doctorschedule = DoctorSchedule::findOrFail($id);
        $doctorschedule->update([
            'doctor_id' => $request->doctor_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('doctorschedules.index')->with('success', 'Data jadwal dokter berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctorschedule = DoctorSchedule::findOrFail($id);
        $doctorschedule->delete();

        return redirect()->route('doctorschedules.index')->with('success', 'Data jadwal dokter berhasil dihapus!');
    }
}
