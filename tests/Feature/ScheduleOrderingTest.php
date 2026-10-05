<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleOrderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_schedule_choices_are_ordered_by_weekday_then_start_time(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $doctor = $this->createDoctor($admin, 'Dr. Jadwal Uji');

        $this->createSchedule($doctor, 'Selasa', '08:00', '12:00');
        $this->createSchedule($doctor, 'Senin', '13:00', '17:00');
        $this->createSchedule($doctor, 'Senin', '08:00', '12:00');

        $response = $this->actingAs($admin)->get(route('registrations.create'));

        $response->assertOk();
        $content = $response->getContent();
        $mondayMorning = strpos($content, 'data-day="Senin" data-start="08:00"');
        $mondayAfternoon = strpos($content, 'data-day="Senin" data-start="13:00"');
        $tuesdayMorning = strpos($content, 'data-day="Selasa" data-start="08:00"');

        $this->assertNotFalse($mondayMorning);
        $this->assertNotFalse($mondayAfternoon);
        $this->assertNotFalse($tuesdayMorning);
        $this->assertLessThan($mondayAfternoon, $mondayMorning);
        $this->assertLessThan($tuesdayMorning, $mondayAfternoon);
    }

    public function test_schedule_list_is_ordered_by_weekday_then_start_time(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $doctor = $this->createDoctor($admin, 'Dr. Jadwal Uji');

        $this->createSchedule($doctor, 'Selasa', '08:00', '12:00');
        $this->createSchedule($doctor, 'Senin', '13:00', '17:00');
        $this->createSchedule($doctor, 'Senin', '08:00', '12:00');

        $response = $this->actingAs($admin)->get(route('doctorschedules.index'));

        $response->assertOk();
        $schedules = $response->viewData('doctorschedules')->items();

        $this->assertSame(
            ['Senin 08:00', 'Senin 13:00', 'Selasa 08:00'],
            array_map(
                fn (DoctorSchedule $schedule) => "{$schedule->hari} {$schedule->jam_mulai}",
                $schedules
            )
        );
    }

    private function createDoctor(User $user, string $name): Doctor
    {
        $department = Department::create([
            'name' => 'Poli Uji',
            'kode_poli' => 'A',
            'description' => 'Poli untuk pengujian',
        ]);

        return Doctor::create([
            'user_id' => $user->id,
            'department_id' => $department->id,
            'nama' => $name,
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
    }

    private function createSchedule(Doctor $doctor, string $day, string $start, string $end): void
    {
        DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'hari' => $day,
            'jam_mulai' => $start,
            'jam_selesai' => $end,
            'kuota' => 10,
        ]);
    }
}
