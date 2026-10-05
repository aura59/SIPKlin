<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $doctorschedules = DoctorSchedule::with('doctor.department')
            ->withCount([
                'registration as registration_today_count' => function ($query) {
                    $query->whereDate('tanggal', today());
                },
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('doctor', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%")
                            ->orWhereHas('department', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->orWhere('hari', 'like', "%{$search}%")
                    ->orWhere('jam_mulai', 'like', "%{$search}%")
                    ->orWhere('jam_selesai', 'like', "%{$search}%");
                });
            })
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
            ->paginate(10)
            ->withQueryString();

        return view('pages.doctorschedule.index', compact('doctorschedules'));
    }

    public function doctorSchedule(Request $request)
    {
        $user = Auth::user();

        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

        $doctorschedules = DoctorSchedule::with('doctor.department')
            ->withCount([
                'registration as registration_today_count' => function ($query) {
                    $query->whereDate('tanggal', today());
                }
            ])
            ->where('doctor_id', $doctor->id)
            ->when($request->string('search')->trim()->toString() !== '', function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('hari', 'like', "%{$search}%")
                        ->orWhere('jam_mulai', 'like', "%{$search}%")
                        ->orWhere('jam_selesai', 'like', "%{$search}%")
                        ->orWhereHas('doctor.department', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
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
            ->paginate(10)
            ->withQueryString();

        return view('pages.doctorschedule.doctor', compact('doctorschedules'));
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

        return redirect()->route('doctorschedules.index', $request->only(['page', 'search']))
            ->with('success', 'Data jadwal dokter berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctorschedule = DoctorSchedule::with('doctor.department')->findOrFail($id);

        if (Auth::user()->role === 'dokter') {
            $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

            if ($doctorschedule->doctor_id != $doctor->id) {
                abort(403);
            }
        }

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

        return redirect()->route('doctorschedules.index', $request->only(['page', 'search']))
            ->with('success', 'Data jadwal dokter berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $doctorschedule = DoctorSchedule::findOrFail($id);
        $doctorschedule->delete();

        return redirect()->route('doctorschedules.index', $request->only(['page', 'search']))
            ->with('success', 'Data jadwal dokter berhasil dihapus!');
    }
}
