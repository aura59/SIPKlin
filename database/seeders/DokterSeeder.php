<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userDokter = User::where('email', 'bojai@gmail.com')->first();

        $poli = Poli::where('nama_poli', 'Poli Umum')->first();

        Dokter::create([
            'user_id' => $userDokter->id,
            'poli_id' => $poli->id,
            'nama' => 'Dr. Hou Minghao',
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
    }
}
