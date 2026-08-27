<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Departement;
use App\Models\User;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userDokter = User::where('email', 'bojai@gmail.com')->first();

        $departement = Departement::where('nama_departement', 'Poli Umum')->first();

        Doctor::create([
            'user_id' => $userDokter->id,
            'departement_id' => $departement->id,
            'nama' => 'Dr. Hou Minghao',
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
    }
}
