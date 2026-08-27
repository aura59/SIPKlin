<?php

namespace Database\Seeders;

use App\Models\DoctorSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokter = Doctor::first(); // Ambil dokter pertama dari database

        DoctorSchedule::create([
            'dokter_id' => $dokter->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '16:00',
            'kuota' => 20,
        ]);
    }
}
