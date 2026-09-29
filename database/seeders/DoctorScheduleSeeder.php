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
        ['Dr. Hau Mingga Pradana', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], '13:00', '17:00', 15],

        // POLI GIGI
        ['Dr. Tiara Xiandra', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], '09:00', '13:00', 8],
        ['Dr. Tiara Xiandra', ['Senin', 'Rabu', 'Jumat'], '14:00', '18:00', 8],

        // POLI ANAK
        ['Dr. Luna Yusvara', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], '08:00', '12:00', 10],
        ['Dr. Luna Yusvara', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], '13:00', '17:00', 10],

        // POLI MATA
        ['Dr. Bella Kaila', ['Senin', 'Rabu', 'Jumat'], '13:00', '17:00', 8],
        ['Dr. Bella Kaila', ['Selasa', 'Kamis'], '14:00', '18:00', 8],

        // POLI KANDUNGAN
        ['Dr. Yura Shavina', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], '08:00', '12:00', 8],
        ['Dr. Yura Shavina', ['Selasa', 'Kamis'], '13:00', '17:00', 8],

        // POLI PENYAKIT DALAM
        ['Dr. Luki Ardhana', ['Senin', 'Rabu', 'Jumat', 'Sabtu'], '08:00', '12:00', 8],
        ['Dr. Luki Ardhana', ['Selasa', 'Kamis'], '13:00', '17:00', 8],

        // POLI THT
        ['Dr. Dena Anesya', ['Senin', 'Rabu', 'Jumat'], '15:00', '19:00', 8],
        ['Dr. Dena Anesya', ['Selasa', 'Kamis', 'Sabtu'], '16:00', '20:00', 8],

        // POLI KULIT DAN KELAMIN
        ['Dr. Chandra Wasena', ['Selasa', 'Kamis', 'Sabtu'], '14:00', '18:00', 8],

        // POLI SARAF
        ['Dr. Heyu Adinata', ['Selasa', 'Kamis'], '16:00', '20:00', 8],
        ['Dr. Heyu Adinata', ['Sabtu'], '13:00', '17:00', 8],

        // POLI BEDAH
        ['Dr. Dion Yudhistira', ['Senin', 'Rabu', 'Jumat'], '17:00', '20:00', 6],
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
