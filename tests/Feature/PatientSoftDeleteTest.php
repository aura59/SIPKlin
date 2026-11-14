<?php

namespace Tests\Feature;

use App\Models\ControlScheduleHistory;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_patient_keeps_visit_medical_record_and_control_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = Department::create([
            'name' => 'Poli Umum',
            'kode_poli' => 'A',
            'description' => 'Poli untuk pengujian',
        ]);
        $doctorUser = User::factory()->create(['role' => 'dokter']);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $department->id,
            'nama' => $doctorUser->name,
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
            'no_rm' => 'TEST-000001',
            'nik' => '1234567890123456',
            'nama' => 'Pasien Arsip',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);
        $registration = Registration::create([
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => today()->toDateString(),
            'catatan' => 'Kunjungan pasien',
            'status' => 'selesai',
        ]);
        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'selesai',
        ]);
        $medicalRecord = MedicalRecord::create([
            'registration_id' => $registration->id,
            'keluhan' => 'Keluhan historis',
            'diagnosis' => 'Diagnosis historis',
            'tindakan' => 'Tindakan historis',
            'perlu_kontrol' => true,
            'tanggal_kontrol' => today()->addDays(7)->toDateString(),
            'catatan_kontrol' => 'Kontrol historis',
        ]);
        $controlHistory = ControlScheduleHistory::create([
            'medical_record_id' => $medicalRecord->id,
            'tanggal_kontrol_lama' => today()->addDays(3)->toDateString(),
            'catatan_kontrol_lama' => 'Jadwal lama',
            'tanggal_kontrol_baru' => today()->addDays(7)->toDateString(),
            'catatan_kontrol_baru' => 'Riwayat kontrol tersimpan',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('patients.destroy', $patient->id));

        $response->assertRedirect(route('patients.index'));
        $this->assertSoftDeleted('patients', ['id' => $patient->id]);
        $this->assertDatabaseHas('registrations', ['id' => $registration->id]);
        $this->assertDatabaseHas('medical_records', ['id' => $medicalRecord->id]);
        $this->assertDatabaseHas('control_schedule_histories', ['id' => $controlHistory->id]);

        $this->actingAs($admin)
            ->get(route('patients.index'))
            ->assertOk()
            ->assertDontSee('Pasien Arsip');

        $this->actingAs($admin)
            ->get(route('visit-history.index'))
            ->assertOk()
            ->assertSee('Pasien Arsip')
            ->assertSee('TEST-000001');

        $this->actingAs($admin)
            ->get(route('visit-history.index', ['search' => 'Pasien Arsip']))
            ->assertOk()
            ->assertSee('Pasien Arsip');

        $this->actingAs($admin)
            ->get(route('visit-history.show', $registration->id))
            ->assertOk()
            ->assertSee('Pasien Arsip')
            ->assertSee('Diagnosis historis')
            ->assertSee('Riwayat kontrol tersimpan');
    }
}
