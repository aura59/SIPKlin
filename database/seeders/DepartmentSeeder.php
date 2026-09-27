<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create([
            'name' => 'Poli Umum',
            'kode_poli' => 'A',
            'description' => 'Unit pelayanan kesehatan tingkat pertama yang menangani keluhan kesehatan umum dan ringan, serta memberikan pemeriksaan, diagnosis awal, dan rujukan ke poli spesialis jika diperlukan.',
        ]);

        Department::create([
            'name' => 'Poli Gigi',
            'kode_poli' => 'B',
            'description' => 'Unit layanan kesehatan yang khusus menangani pemeriksaan, perawatan, dan pengobatan masalah gigi dan mulut.',
        ]);

        Department::create([
            'name' => 'Poli Anak',
            'kode_poli' => 'C',
            'description' => '	Layanan poliklinik khusus yang menangani kesehatan bayi, balita, dan anak hingga usia remaja, termasuk pemeriksaan rutin, pengobatan penyakit, imunisasi, serta pemantauan tumbuh kembang.',
        ]);

        Department::create([
            'name' => 'Poli Mata',
            'kode_poli' => 'D',
            'description' => 'Unit pelayanan medis yang berfokus pada pemeriksaan, diagnosis, dan pengobatan berbagai gangguan kesehatan mata serta fungsi penglihatan.',
        ]);

        Department::create([
            'name' => 'Poli Kandungan',
            'kode_poli' => 'E',
            'description' => 'Unit pelayanan medis yang khusus menangani kesehatan reproduksi wanita, termasuk pemeriksaan, perawatan, serta penanganan masalah kehamilan dan organ reproduksi.',
        ]);

        Department::create([
            'name' => 'Poli Penyakit Dalam',
            'kode_poli' => 'F',
            'description' => 'Layanan medis untuk orang dewasa yang menangani diagnosis, pengobatan, dan pencegahan penyakit non‑bedah pada organ dalam seperti jantung, paru, ginjal, hati, pencernaan, dan hormon.',
        ]);

        Department::create([
            'name' => 'Poli THT',
            'kode_poli' => 'G',
            'description' => 'Unit layanan kesehatan yang khusus menangani masalah pada Telinga, Hidung, Tenggorokan, serta kepala dan leher.',
        ]);

        Department::create([
            'name' => 'Poli Kulit dan Kelamin',
            'kode_poli' => 'H',
            'description' => 'Unit pelayanan kesehatan yang menangani masalah kulit, rambut, kuku, dan organ kelamin, baik pada pria maupun wanita, dengan diagnosis, pengobatan, dan pencegahan yang spesialis.',
        ]);

        Department::create([
            'name' => 'Poli Saraf',
            'kode_poli' => 'I',
            'description' => '	Fasilitas kesehatan yang menyediakan pelayanan untuk pasien yang mengalami gangguan pada sistem saraf, baik itu otak, sumsum tulang belakang, saraf tepi, maupun otot.',
        ]);

        Department::create([
            'name' => 'Poli Bedah',
            'kode_poli' => 'J',
            'description' => 'Fasilitas kesehatan yang melayani pasien dengan keluhan atau kondisi medis yang berpotensi membutuhkan penanganan bedah.',
        ]);
    }
}