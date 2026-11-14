<?php

namespace Tests\Feature;

use App\Models\ControlScheduleHistory;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControlScheduleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_view_control_schedules_without_admin_actions(): void
    {
        $doctorUser = User::factory()->create(['role' => 'dokter']);
        $record = $this->createControlSchedule($doctorUser, today()->subDay());

        $response = $this->actingAs($doctorUser)->get(route('control-schedules.index'));

        $response->assertOk()
            ->assertSee($record->registration->patient->nama)
            ->assertDontSee('Jadwalkan Ulang')
            ->assertDontSee('Daftarkan Pasien')
            ->assertDontSee('Belum Waktunya');
    }

    public function test_doctor_cannot_reschedule_or_register_a_patient_from_control_schedules(): void
    {
        $doctorUser = User::factory()->create(['role' => 'dokter']);
        $record = $this->createControlSchedule($doctorUser, today()->subDay());

        $this->actingAs($doctorUser)
            ->patch(route('control-schedules.reschedule', $record->id), [
                'tanggal_kontrol_baru' => today()->addDay()->toDateString(),
            ])
            ->assertRedirect(route('doctor.dashboard'));

        $this->assertDatabaseHas('medical_records', [
            'id' => $record->id,
            'tanggal_kontrol' => today()->subDay()->toDateString(),
        ]);
        $this->assertDatabaseCount('control_schedule_histories', 0);

        $this->get(route('registrations.create', [
            'patient_id' => $record->registration->patient_id,
        ]))->assertRedirect(route('doctor.dashboard'));
    }

    public function test_admin_can_view_actions_and_reschedule_a_missed_control_schedule(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->createControlSchedule(
            User::factory()->create(['role' => 'dokter']),
            today()->subDay()
        );

        $this->actingAs($admin)
            ->get(route('control-schedules.index'))
            ->assertOk()
            ->assertSee('Jadwalkan Ulang');

        $this->patch(route('control-schedules.reschedule', $record->id), [
            'tanggal_kontrol_baru' => today()->addDay()->toDateString(),
        ])->assertRedirect(route('control-schedules.index'));

        $this->assertDatabaseHas('medical_records', [
            'id' => $record->id,
            'tanggal_kontrol' => today()->addDay()->toDateString(),
        ]);
        $this->assertDatabaseHas('control_schedule_histories', [
            'medical_record_id' => $record->id,
            'user_id' => $admin->id,
        ]);
    }

    public function test_admin_can_open_patient_registration_from_control_schedule(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->createControlSchedule(
            User::factory()->create(['role' => 'dokter']),
            today()
        );

        $this->actingAs($admin)
            ->get(route('registrations.create', [
                'patient_id' => $record->registration->patient_id,
            ]))
            ->assertOk();
    }

    private function createControlSchedule(User $doctorUser, $controlDate): MedicalRecord
    {
        $department = Department::create([
            'name' => 'Poli Uji',
            'kode_poli' => 'A',
        ]);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $department->id,
            'nama' => 'Dokter Uji',
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
        $schedule = DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
        ]);
        $patient = Patient::create([
            'no_rm' => 'RM-' . uniqid(),
            'nik' => str_pad((string) random_int(1, 9999999999999999), 16, '0', STR_PAD_LEFT),
            'nama' => 'Pasien Jadwal Uji',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat uji',
            'no_telepon' => '081234567891',
        ]);
        $registration = Registration::create([
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => today()->toDateString(),
            'catatan' => 'Kontrol',
            'status' => 'selesai',
        ]);

        return MedicalRecord::create([
            'registration_id' => $registration->id,
            'keluhan' => 'Keluhan uji',
            'diagnosis' => 'Diagnosis uji',
            'tindakan' => 'Tindakan uji',
            'perlu_kontrol' => true,
            'tanggal_kontrol' => $controlDate->toDateString(),
            'catatan_kontrol' => 'Catatan kontrol',
        ]);
    }
}
