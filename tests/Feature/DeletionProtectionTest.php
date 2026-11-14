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
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeletionProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_without_a_schedule_can_be_deleted_and_standard_pages_still_work(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();
        $doctor = $this->createDoctor($department);

        $this->actingAs($admin)
            ->get(route('doctors.index'))
            ->assertOk();
        $this->get(route('doctors.create'))->assertOk();
        $this->get(route('doctors.show', $doctor))->assertOk();
        $this->get(route('doctors.edit', $doctor))->assertOk();
        $this->get(route('departments.index'))->assertOk();
        $this->get(route('departments.create'))->assertOk();
        $this->get(route('departments.show', $department))->assertOk();
        $this->get(route('departments.edit', $department))->assertOk();

        $response = $this->delete(route('doctors.destroy', $doctor));

        $response->assertRedirect(route('doctors.index'))
            ->assertSessionHas('success', 'Data dokter berhasil dihapus!');
        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
        $this->assertDatabaseHas('users', ['id' => $doctor->user_id]);
    }

    public function test_doctor_with_a_schedule_and_department_in_use_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();
        $doctor = $this->createDoctor($department);
        $this->createSchedule($doctor);

        $this->actingAs($admin)
            ->delete(route('doctors.destroy', $doctor))
            ->assertRedirect(route('doctors.index'))
            ->assertSessionHas('error', 'Data dokter tidak dapat dihapus karena masih memiliki jadwal dokter.');

        $this->delete(route('departments.destroy', $department))
            ->assertRedirect(route('departments.index'))
            ->assertSessionHas('error', 'Data poli tidak dapat dihapus karena masih digunakan oleh dokter.');

        $this->assertDatabaseHas('doctors', ['id' => $doctor->id]);
        $this->assertDatabaseHas('departments', ['id' => $department->id]);
    }

    public function test_service_history_and_its_related_records_are_protected_from_deletion(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();
        $doctorUser = User::factory()->create(['role' => 'dokter']);
        $doctor = $this->createDoctor($department, $doctorUser);
        $schedule = $this->createSchedule($doctor);
        $patient = $this->createPatient();
        $registration = Registration::create([
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => today()->toDateString(),
            'catatan' => 'Keluhan pasien',
            'status' => 'selesai',
        ]);
        $queue = Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'selesai',
        ]);
        $medicalRecord = MedicalRecord::create([
            'registration_id' => $registration->id,
            'keluhan' => 'Keluhan pasien',
            'diagnosis' => 'Diagnosis pasien',
            'tindakan' => 'Tindakan pasien',
        ]);
        $controlHistory = ControlScheduleHistory::create([
            'medical_record_id' => $medicalRecord->id,
            'tanggal_kontrol_lama' => today()->toDateString(),
            'tanggal_kontrol_baru' => today()->addDay()->toDateString(),
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        $this->delete(route('doctors.destroy', $doctor))
            ->assertSessionHas('error');
        $this->delete(route('departments.destroy', $department))
            ->assertSessionHas('error');
        $this->delete(route('doctorschedules.destroy', $schedule))
            ->assertSessionHas('error');

        $this->assertDeleteRestricted(fn () => DB::table('patients')->where('id', $patient->id)->delete());
        $this->assertDeleteRestricted(fn () => DB::table('users')->where('id', $doctorUser->id)->delete());
        $this->assertDeleteRestricted(fn () => DB::table('departments')->where('id', $department->id)->delete());
        $this->assertDeleteRestricted(fn () => DB::table('doctors')->where('id', $doctor->id)->delete());
        $this->assertDeleteRestricted(fn () => DB::table('doctor_schedules')->where('id', $schedule->id)->delete());
        $this->assertDeleteRestricted(fn () => DB::table('registrations')->where('id', $registration->id)->delete());
        $this->assertDeleteRestricted(fn () => DB::table('medical_records')->where('id', $medicalRecord->id)->delete());

        $this->assertDatabaseHas('queues', ['id' => $queue->id, 'registration_id' => $registration->id]);
        $this->assertDatabaseHas('medical_records', ['id' => $medicalRecord->id, 'registration_id' => $registration->id]);
        $this->assertDatabaseHas('control_schedule_histories', ['id' => $controlHistory->id]);

        $this->get(route('visit-history.index'))
            ->assertOk()
            ->assertSee($patient->nama);
        $this->get(route('visit-history.show', $registration))
            ->assertOk()
            ->assertSee($patient->nama)
            ->assertSee('Diagnosis pasien');
    }

    public function test_schedule_without_registrations_can_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $doctor = $this->createDoctor($this->createDepartment());
        $schedule = $this->createSchedule($doctor);

        $this->actingAs($admin)
            ->get(route('doctorschedules.index'))
            ->assertOk();
        $this->get(route('doctorschedules.create'))->assertOk();
        $this->get(route('doctorschedules.show', $schedule))->assertOk();
        $this->get(route('doctorschedules.edit', $schedule))->assertOk();

        $this->delete(route('doctorschedules.destroy', $schedule))
            ->assertRedirect(route('doctorschedules.index'))
            ->assertSessionHas('success', 'Data jadwal dokter berhasil dihapus!');

        $this->assertDatabaseMissing('doctor_schedules', ['id' => $schedule->id]);
    }

    private function assertDeleteRestricted(callable $delete): void
    {
        try {
            $delete();
            $this->fail('Expected the foreign key to restrict deletion.');
        } catch (QueryException) {
            $this->assertTrue(true);
        }
    }

    private function createDepartment(): Department
    {
        return Department::create([
            'name' => 'Poli Umum',
            'kode_poli' => 'A',
            'description' => 'Poli untuk pengujian',
        ]);
    }

    private function createDoctor(Department $department, ?User $user = null): Doctor
    {
        $user ??= User::factory()->create(['role' => 'dokter']);

        return Doctor::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'department_id' => $department->id,
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
    }

    private function createSchedule(Doctor $doctor): DoctorSchedule
    {
        return DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
        ]);
    }

    private function createPatient(): Patient
    {
        return Patient::create([
            'no_rm' => 'TEST-' . fake()->unique()->numerify('######'),
            'nik' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);
    }
}
