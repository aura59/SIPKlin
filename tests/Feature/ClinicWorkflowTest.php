<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClinicWorkflowTest extends TestCase
{
    use RefreshDatabase;

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

        $response->assertRedirect(route('queues.index'));
        $registration = Registration::firstOrFail();
        $this->assertDatabaseHas('queues', [
            'registration_id' => $registration->id,
            'nomor_antrean' => 1,
            'status' => 'menunggu',
        ]);
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
        $registration = $this->createRegistrationForDoctor($patientDoctor, 'dipanggil');

        $response = $this->actingAs($loggedInDoctor)->post(route('medical-records.store'), [
            'registration_id' => $registration->id,
            'keluhan' => 'Sakit kepala',
            'diagnosis' => 'Migrain',
            'tindakan' => 'Istirahat',
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
        $registration = $this->createRegistrationForDoctor($doctor, 'dipanggil');
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
        ]);

        $response->assertRedirect(route('queues.index'));
        $this->assertDatabaseHas('medical_records', [
            'registration_id' => $registration->id,
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

    private function createRegistrationForDoctor(Doctor $doctor, string $status): Registration
    {
        $schedule = DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
        ]);

        $patient = Patient::create([
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
