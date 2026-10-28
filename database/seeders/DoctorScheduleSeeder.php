<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
        // POLI UMUM 
        ['Dr. Hau Mingga Pradana', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], '08:00', '12:00', 15],
        ['Dr. Hau Mingga Pradana', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], '16:00', '21:00', 15],

        // POLI GIGI 
        ['Dr. Tiara Xiandra', ['Selasa', 'Kamis', 'Sabtu'], '08:00', '12:00', 8],
        ['Dr. Tiara Xiandra', ['Senin', 'Rabu', 'Jumat'], '16:00', '21:00', 8],

        // POLI ANAK 
        ['Dr. Luna Yusvara', ['Senin', 'Rabu', 'Jumat'], '08:00', '12:00', 10],
        ['Dr. Luna Yusvara', ['Selasa', 'Kamis'], '16:00', '20:00', 10],

        // POLI KANDUNGAN 
        ['Dr. Yura Shavina', ['Senin', 'Rabu', 'Jumat', 'Sabtu'], '08:00', '12:00', 8],
        ['Dr. Yura Shavina', ['Selasa', 'Kamis'], '16:00', '20:00', 8],

        // POLI PENYAKIT DALAM 
        ['Dr. Luki Ardhana', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], '08:00', '12:00', 8],

        // POLI MATA 
        ['Dr. Bella Kaila', ['Senin', 'Rabu', 'Jumat'], '08:00', '12:00', 8],
        ['Dr. Bella Kaila', ['Selasa', 'Kamis'], '16:00', '20:00', 8],

        // POLI THT 
        ['Dr. Dena Anesya', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], '16:00', '21:00', 8],

        // POLI KULIT DAN KELAMIN 
        ['Dr. Chandra Wasena', ['Senin', 'Rabu', 'Jumat'], '16:00', '21:00', 8],

        // POLI SARAF 
        ['Dr. Heyu Adinata', ['Selasa', 'Kamis'], '16:00', '21:00', 8],
        ['Dr. Heyu Adinata', ['Sabtu'], '16:00', '19:00', 8],

        // POLI BEDAH 
        ['Dr. Dion Yudhistira', ['Senin', 'Rabu', 'Jumat'], '17:00', '21:00', 6],
    ];


        foreach ($doctors as $data) {
            $doctor = Doctor::where('nama', $data[0])->first();

            if (!$doctor) {
                $this->command->warn("Dokter {$data[0]} tidak ditemukan. Lewati jadwal.");
                continue;
            }

            foreach ($data[1] as $namaHari) {
                DoctorSchedule::updateOrCreate(
                    [
                        'doctor_id' => $doctor->id,
                        'hari' => $namaHari,
                        'jam_mulai' => $data[2], 
                    ],
                    [
                        'jam_selesai' => $data[3], 
                        'kuota' => $data[4],       
                    ]
                );
            }
        }
    }
}
