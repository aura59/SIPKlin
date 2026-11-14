<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ClinicWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_disables_dates_before_today(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('registrations.create'));

        $response->assertOk()
            ->assertSee('type="date"', false)
            ->assertSee('min="' . today()->toDateString() . '"', false);
    }

    public function test_admin_and_doctor_dashboards_show_today_control_schedules(): void
    {
        DB::connection()->getPdo()->sqliteCreateFunction(
            'MONTH',
            static fn (string $date): int => (int) substr($date, 5, 2)
        );

        $registration = $this->createRegistration('menunggu');
        $patientName = $registration->patient->nama;

        $doctorUser = $registration->doctorSchedule->doctor->user;

        MedicalRecord::create([
            'registration_id' => $registration->id,
            'keluhan' => 'Keluhan pasien',
            'diagnosis' => 'Diagnosis pasien',
            'tindakan' => 'Tindakan pasien',
            'perlu_kontrol' => true,
            'tanggal_kontrol' => today()->toDateString(),
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $dashboards = [
            [
                'user' => $admin,
                'route' => 'admin.dashboard',
            ],
            [
                'user' => $doctorUser,
                'route' => 'doctor.dashboard',
            ],
        ];

        foreach ($dashboards as $dashboard) {
            $response = $this->actingAs($dashboard['user'])
                ->get(route($dashboard['route']));

            $response->assertOk()
                ->assertViewHas('totalKontrolHariIni', 1)
                ->assertSee($patientName);
        }
    }

    public function test_registration_rejects_a_date_before_today(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment('Poli Umum', 'A');

        $doctor = $this->createDoctor(
            User::factory()->create(['role' => 'dokter']),
            $department
        );

        $pastDate = today()->subDay();

        $schedule = DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => $pastDate->copy()->locale('id')->translatedFormat('l'),
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
        ]);

        $patient = Patient::create([
            'no_rm' => 'TEST-' . fake()->unique()->numerify('######'),
            'nik' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);

        $response = $this->actingAs($admin)->post(route('registrations.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => $pastDate->toDateString(),
            'catatan' => 'Keluhan pasien',
        ]);

        $response->assertSessionHasErrors('tanggal');
        $this->assertDatabaseCount('registrations', 0);
        $this->assertDatabaseCount('queues', 0);
    }

    public function test_admin_can_call_a_waiting_queue(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $registration = $this->createRegistration('menunggu');

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('queues.call', $registration));

        $response->assertRedirect();

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'dipanggil',
        ]);

        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'status' => 'dipanggil',
        ]);
    }

    public function test_doctor_cannot_call_a_queue(): void
    {
        $doctor = User::factory()->create(['role' => 'dokter']);
        $registration = $this->createRegistration('menunggu');

        $response = $this->actingAs($doctor)
            ->patch(route('queues.call', $registration));

        $response->assertRedirect(route('doctor.dashboard'));

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'menunggu',
        ]);
    }

    public function test_completed_queue_cannot_be_called_again(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $registration = $this->createRegistration('selesai');

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'selesai',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('queues.call', $registration));

        $response->assertSessionHasErrors('registration');

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'selesai',
        ]);
    }

    public function test_registration_is_rejected_when_the_schedule_quota_is_full(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment('Poli Umum', 'A');

        $doctor = $this->createDoctor(
            User::factory()->create(['role' => 'dokter']),
            $department
        );

        $date = today();

        $schedule = DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => $date->copy()->locale('id')->translatedFormat('l'),
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 1,
        ]);

        $patient = Patient::create([
            'no_rm' => 'TEST-' . fake()->unique()->numerify('######'),
            'nik' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);

        Registration::create([
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => $date->toDateString(),
            'catatan' => 'Keluhan pasien',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)->post(route('registrations.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => $date->toDateString(),
            'catatan' => 'Keluhan pasien kedua',
        ]);

        $response->assertSessionHasErrors('doctor_schedule_id');

        $this->assertDatabaseCount('registrations', 1);
        $this->assertDatabaseCount('queues', 0);
    }

    public function test_registration_and_queue_are_created_together(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment('Poli Umum', 'A');

        $doctor = $this->createDoctor(
            User::factory()->create(['role' => 'dokter']),
            $department
        );

        $date = today();

        $schedule = DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => $date->copy()->locale('id')->translatedFormat('l'),
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 1,
        ]);

        $patient = Patient::create([
            'no_rm' => 'TEST-' . fake()->unique()->numerify('######'),
            'nik' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);

        $response = $this->actingAs($admin)->post(route('registrations.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => $date->toDateString(),
            'catatan' => 'Keluhan pasien',
        ]);

        $registration = Registration::firstOrFail();

        $response->assertRedirect(
            route('registrations.ticket', $registration->id)
        );

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $schedule->id,
            'status' => 'menunggu',
        ]);

        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'menunggu',
        ]);

        $ticketResponse = $this->actingAs($admin)
            ->get(route('registrations.ticket', $registration->id));

        $ticketResponse->assertOk()
            ->assertSee($patient->nama);
    }

    public function test_doctor_cannot_create_medical_record_for_another_doctors_patient(): void
    {
        $loggedInDoctor = User::factory()->create(['role' => 'dokter']);
        $ownDepartment = $this->createDepartment('Poli A', 'A');

        $this->createDoctor($loggedInDoctor, $ownDepartment);

        $patientDepartment = $this->createDepartment('Poli B', 'B');

        $patientDoctor = $this->createDoctor(
            User::factory()->create(['role' => 'dokter']),
            $patientDepartment
        );

        $registration = $this->createRegistrationForDoctor(
            $patientDoctor,
            'dipanggil'
        );

        $response = $this->actingAs($loggedInDoctor)->post(route('medical-records.store'), [
            'registration_id' => $registration->id,
            'keluhan' => 'Sakit kepala',
            'diagnosis' => 'Migrain',
            'tindakan' => 'Istirahat',
            'perlu_kontrol' => false,
        ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('medical_records', [
            'registration_id' => $registration->id,
        ]);
    }

    public function test_doctor_can_create_medical_record_for_their_called_patient(): void
    {
        $doctorUser = User::factory()->create(['role' => 'dokter']);

        $doctor = $this->createDoctor(
            $doctorUser,
            $this->createDepartment('Poli A', 'A')
        );

        $registration = $this->createRegistrationForDoctor(
            $doctor,
            'dipanggil'
        );

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'dipanggil',
        ]);

        $response = $this->actingAs($doctorUser)->post(route('medical-records.store'), [
            'registration_id' => $registration->id,
            'keluhan' => 'Sakit kepala',
            'diagnosis' => 'Migrain',
            'tindakan' => 'Istirahat',
            'perlu_kontrol' => false,
        ]);

        $response->assertRedirect(route('queues.index'));

        $this->assertDatabaseHas('medical_records', [
            'registration_id' => $registration->id,
            'perlu_kontrol' => false,
        ]);

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'selesai',
        ]);

        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'status' => 'selesai',
        ]);
    }

    public function test_admin_can_finish_called_queue_with_medical_record(): void
    {
        $registration = $this->createRegistration('dipanggil');

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'dipanggil',
        ]);

        MedicalRecord::create([
            'registration_id' => $registration->id,
            'keluhan' => 'Keluhan pasien',
            'diagnosis' => 'Diagnosis pasien',
            'tindakan' => 'Tindakan pasien',
            'perlu_kontrol' => false,
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('queues.finish', $registration->id));

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'selesai',
        ]);

        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'status' => 'selesai',
        ]);
    }

    public function test_doctor_can_finish_their_own_called_queue(): void
    {
        $registration = $this->createRegistration('dipanggil');

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'dipanggil',
        ]);

        MedicalRecord::create([
            'registration_id' => $registration->id,
            'keluhan' => 'Keluhan pasien',
            'diagnosis' => 'Diagnosis pasien',
            'tindakan' => 'Tindakan pasien',
            'perlu_kontrol' => false,
        ]);

        $doctorUser = $registration->doctorSchedule->doctor->user;

        $response = $this->actingAs($doctorUser)
            ->patch(route('queues.finish', $registration->id));

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'selesai',
        ]);

        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'status' => 'selesai',
        ]);
    }

    public function test_doctor_cannot_finish_another_doctors_queue(): void
    {
        $ownRegistration = $this->createRegistration('menunggu');
        $otherRegistration = $this->createRegistration('dipanggil');

        Queue::create([
            'registration_id' => $otherRegistration->id,
            'nomor_antrean' => 1,
            'status' => 'dipanggil',
        ]);

        $doctorUser = $ownRegistration->doctorSchedule->doctor->user;

        $response = $this->actingAs($doctorUser)
            ->patch(route('queues.finish', $otherRegistration->id));

        $response->assertForbidden();

        $this->assertDatabaseHas('registrations', [
            'id' => $otherRegistration->id,
            'status' => 'dipanggil',
        ]);
    }

    public function test_queue_cannot_be_finished_without_medical_record(): void
    {
        $registration = $this->createRegistration('dipanggil');

        Queue::create([
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'dipanggil',
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('queues.finish', $registration->id));

        $response->assertSessionHasErrors('registration');

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'dipanggil',
        ]);

        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'status' => 'dipanggil',
        ]);
    }

    private function createRegistration(string $status): Registration
    {
        return $this->createRegistrationForDoctor(
            $this->createDoctor(
                User::factory()->create(['role' => 'dokter']),
                $this->createDepartment('Poli Umum', 'A')
            ),
            $status
        );
    }

    private function createRegistrationForDoctor(
        Doctor $doctor,
        string $status
    ): Registration {
        $schedule = DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
        ]);

        $patient = Patient::create([
            'no_rm' => 'TEST-' . fake()->unique()->numerify('######'),
            'nik' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);

        return Registration::create([
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $schedule->id,
            'tanggal' => today()->toDateString(),
            'catatan' => 'Keluhan pasien',
            'status' => $status,
        ]);
    }

    private function createDoctor(User $user, Department $department): Doctor
    {
        return Doctor::create([
            'user_id' => $user->id,
            'department_id' => $department->id,
            'nama' => $user->name,
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
    }

    private function createDepartment(string $name, string $code): Department
    {
        return Department::create([
            'name' => $name,
            'kode_poli' => $code,
            'description' => 'Poli untuk pengujian',
        ]);
    }
}