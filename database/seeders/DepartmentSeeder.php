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
            'description' => 'Pelayanan kesehatan umum untuk semua pasien.',
        ]);

        Department::create([
            'name' => 'Poli Gigi',
            'kode_poli' => 'B',
            'description' => 'Pelayanan kesehatan gigi dan mulut.',
        ]);

        Department::create([
            'name' => 'Poli Anak',
            'kode_poli' => 'C',
            'description' => 'Pelayanan kesehatan khusus untuk anak-anak.',
        ]);

        Department::create([
            'name' => 'Poli Mata',
            'kode_poli' => 'D',
            'description' => 'Pelayanan kesehatan khusus mata.',
        ]);

        Department::create([
            'name' => 'Poli Kandungan',
            'kode_poli' => 'E',
            'description' => 'Pelayanan kesehatan Reproduksi Wanita.',
        ]);

        Department::create([
            'name' => 'Poli Penyakit Dalam',
            'kode_poli' => 'F',
            'description' => 'Pelayanan kesehatan khusus orang dewasa.',
        ]);

        Department::create([
            'name' => 'Poli THT',
            'kode_poli' => 'G',
            'description' => 'Pelayanan kesehatan khusus untuk Telingan, Hidung, dan Tenggorokan.',
        ]);

        Department::create([
            'name' => 'Poli Kulit dan Kelamin',
            'kode_poli' => 'H',
            'description' => 'Pelayanan kesehatan kulit dan kelamin.',
        ]);

        Department::create([
            'name' => 'Poli Saraf',
            'kode_poli' => 'I',
            'description' => 'Pelayanan kesehatan khusus saraf.',
        ]);

        Department::create([
            'name' => 'Poli Bedah',
            'kode_poli' => 'J',
            'description' => 'Pelayanan kesehatan khusus untuk penanganan bedah.',
        ]);
    }
}