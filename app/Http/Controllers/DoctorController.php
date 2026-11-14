<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::paginate(10);
        return view('pages.doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'dokter')
            ->with('dokter')
            ->get();
        $departments = Department::all();

        return view('pages.doctor.create', compact('users', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_type' => ['required', Rule::in(['existing', 'new'])],
            'user_id' => [
                'required_if:account_type,existing',
                'nullable',
                'integer',
                Rule::exists('users', 'id')->where('role', 'dokter'),
                Rule::unique('doctors', 'user_id'),
            ],
            'email' => [
                'required_if:account_type,new',
                'nullable',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => ['required_if:account_type,new', 'nullable', 'string', 'min:8'],
            'nama' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'spesialis' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            if ($validated['account_type'] === 'new') {
                $user = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'dokter',
                ]);
            } else {
                $user = User::whereKey($validated['user_id'])
                    ->where('role', 'dokter')
                    ->lockForUpdate()
                    ->first();

                if (!$user || $user->dokter()->exists()) {
                    throw ValidationException::withMessages([
                        'user_id' => 'Akun dokter tidak tersedia atau sudah terhubung dengan data dokter.',
                    ]);
                }
            }

            $user->dokter()->create([
                'nama' => $validated['nama'],
                'department_id' => $validated['department_id'],
                'spesialis' => $validated['spesialis'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        });

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('pages.doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $users = User::where('role', 'dokter')->get();
        $departments = Department::all();

        return view('pages.doctor.edit', compact('doctor', 'users', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, string $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'dokter');
                }),
                Rule::unique('doctors', 'user_id')->ignore($doctor->id),
            ],
            'nama' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'spesialis' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
        ], [
            'user_id.exists' => 'Akun yang dipilih bukan akun dokter atau tidak tersedia.',
            'user_id.unique' => 'Akun tersebut sudah terhubung dengan data dokter lain.',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        // Cegah penghapusan dokter jika masih memiliki jadwal.
        if ($doctor->jadwal()->exists()) {
            return redirect()
                ->route('doctors.index')
                ->with('error', 'Data dokter tidak dapat dihapus karena masih memiliki jadwal dokter.');
        }

        $doctor->delete();

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Data dokter berhasil dihapus!');
    }

}
