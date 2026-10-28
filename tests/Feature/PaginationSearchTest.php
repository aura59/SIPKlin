<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginationSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_search_finds_records_beyond_the_current_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        foreach (range(1, 11) as $number) {
            $this->createPatient(sprintf('Patient %02d', $number));
        }

        $response = $this->get(route('patients.index', ['search' => 'Patient 11']));

        $response->assertOk()
            ->assertSee('Patient 11')
            ->assertViewHas('patients', function ($patients) {
                return $patients->total() === 1 && $patients->currentPage() === 1;
            });
    }

    public function test_patient_list_orders_newest_records_first(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $firstPatient = $this->createPatient('Patient 01');
        $latestPatient = $this->createPatient('Patient 02');

        $response = $this->get(route('patients.index'));

        $response->assertOk()
            ->assertViewHas('patients', function ($patients) use ($firstPatient, $latestPatient) {
                $names = $patients->pluck('nama')->all();

                return $names[0] === $latestPatient->nama
                    && $names[1] === $firstPatient->nama;
            });
    }

    public function test_department_search_finds_records_beyond_the_current_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        foreach (range(1, 11) as $number) {
            Department::create([
                'name' => sprintf('Poli %02d', $number),
                'kode_poli' => chr(64 + $number),
                'description' => 'Poli untuk pengujian',
            ]);
        }

        $response = $this->get(route('departments.index', ['search' => 'Poli 11']));

        $response->assertOk()
            ->assertSee('Poli 11')
            ->assertViewHas('departments', function ($departments) {
                return $departments->total() === 1 && $departments->currentPage() === 1;
            });
    }

    public function test_schedule_search_finds_records_beyond_the_current_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $department = Department::create([
            'name' => 'Poli Umum',
            'kode_poli' => 'A',
            'description' => 'Poli untuk pengujian',
        ]);

        foreach (range(1, 11) as $number) {
            $doctorUser = User::factory()->create(['role' => 'dokter']);
            $doctor = Doctor::create([
                'user_id' => $doctorUser->id,
                'department_id' => $department->id,
                'nama' => sprintf('Dokter %02d', $number),
                'spesialis' => 'Umum',
                'no_telepon' => '081234567890',
            ]);

            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '12:00',
                'kuota' => 10,
            ]);
        }

        $response = $this->get(route('doctorschedules.index', ['search' => 'Dokter 11']));

        $response->assertOk()
            ->assertSee('Dokter 11')
            ->assertViewHas('doctorschedules', function ($schedules) {
                return $schedules->total() === 1 && $schedules->currentPage() === 1;
            });
    }

    public function test_patient_actions_keep_the_current_page_and_search(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $patient = null;
        foreach (range(1, 11) as $number) {
            $patient = $this->createPatient(sprintf('Patient %02d', $number));
        }

        $response = $this->get(route('patients.index', ['page' => 1, 'search' => 'Patient']));

        $response->assertOk()
            ->assertSee(e(route('patients.show', [
                'patient' => $patient->id,
                'page' => 1,
                'search' => 'Patient',
            ])), false);

        $detailResponse = $this->get(route('patients.show', [
            'patient' => $patient->id,
            'page' => 1,
            'search' => 'Patient',
        ]));

        $detailResponse->assertOk()
            ->assertSee(e(route('patients.index', ['page' => 1, 'search' => 'Patient'])), false);

        $updateResponse = $this->put(route('patients.update', [
            'patient' => $patient->id,
            'page' => 1,
            'search' => 'Patient',
        ]), [
            'nik' => $patient->nik,
            'nama' => 'Patient 11 Updated',
            'tanggal_lahir' => $patient->tanggal_lahir,
            'jenis_kelamin' => $patient->jenis_kelamin,
            'alamat' => $patient->alamat,
            'no_telepon' => $patient->no_telepon,
        ]);

        $updateResponse->assertRedirect(route('patients.index', [
            'page' => 1,
            'search' => 'Patient',
        ]));

        $deleteResponse = $this->delete(route('patients.destroy', [
            'patient' => $patient->id,
            'page' => 1,
            'search' => 'Patient',
        ]));

        $deleteResponse->assertRedirect(route('patients.index', [
            'page' => 1,
            'search' => 'Patient',
        ]));
    }

    public function test_patient_creation_keeps_the_list_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $response = $this->post(route('patients.store', ['page' => 2, 'search' => 'Patient']), [
            'nik' => fake()->unique()->numerify('################'),
            'nama' => 'Patient Baru',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);

        $response->assertRedirect(route('patients.index', [
            'page' => 2,
            'search' => 'Patient',
        ]));
    }

    public function test_doctor_schedule_list_accepts_search(): void
    {
        $doctorUser = User::factory()->create(['role' => 'dokter']);
        $department = Department::create([
            'name' => 'Poli Umum',
            'kode_poli' => 'A',
            'description' => 'Poli untuk pengujian',
        ]);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $department->id,
            'nama' => 'Dokter Pemilik',
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
        DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
        ]);

        $response = $this->actingAs($doctorUser)
            ->get(route('doctor.schedules', ['search' => 'Senin']));

        $response->assertOk()
            ->assertSee('Senin')
            ->assertViewHas('doctorschedules', function ($schedules) {
                return $schedules->total() === 1;
            });
    }

    private function createPatient(string $name): Patient
    {
        return Patient::create([
            'nik' => fake()->unique()->numerify('################'),
            'nama' => $name,
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Alamat pasien',
            'no_telepon' => '081234567890',
        ]);
    }
}
