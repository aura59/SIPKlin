<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userDokter = User::where('email', 'bojai@gmail.com')->first();

        $department = Department::where('name', 'Poli Umum')->first();

        Doctor::create([
            'user_id' => $userDokter->id,
            'department_id' => $department->id,
            'nama' => 'Dr. Hou Minghao',
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);

        $userDokter = User::where('email', 'xiaoxiao@gmail.com')->first();

        $department = Department::where('name', 'Poli Anak')->first();

        Doctor::create([
            'user_id' => $userDokter->id,
            'department_id' => $department->id,
            'nama' => 'Dr. Lu Yuxiao',
            'spesialis' => 'Anak',
            'no_telepon' => '083813054300',
        ]);
    }
}
