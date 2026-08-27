<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departement::create([
            'nama_departement' => 'Poli Umum',
            'deskripsi' => 'Pelayanan kesehatan umum untuk semua pasien.',
        ]);

        Departement::create([
            'nama_departement' => 'Poli Gigi',
            'deskripsi' => 'Pelayanan kesehatan gigi dan mulut.',
        ]);

        Departement::create([
            'nama_departement' => 'Poli Anak',
            'deskripsi' => 'Pelayanan kesehatan khusus untuk anak-anak.',
        ]);
    }
}
