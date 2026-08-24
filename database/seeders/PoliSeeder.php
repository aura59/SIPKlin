<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poli::create([
            'nama_poli' => 'Poli Umum',
            'deskripsi' => 'Pelayanan kesehatan umum untuk semua pasien.',
        ]);

        Poli::create([
            'nama_poli' => 'Poli Gigi',
            'deskripsi' => 'Pelayanan kesehatan gigi dan mulut.',
        ]);

        Poli::create([
            'nama_poli' => 'Poli Anak',
            'deskripsi' => 'Pelayanan kesehatan khusus untuk anak-anak.',
        ]);
    }
}
