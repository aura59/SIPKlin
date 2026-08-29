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
            'description' => 'Pelayanan kesehatan umum untuk semua pasien.',
        ]);

        Department::create([
            'name' => 'Poli Gigi',
            'description' => 'Pelayanan kesehatan gigi dan mulut.',
        ]);

        Department::create([
            'name' => 'Poli Anak',
            'description' => 'Pelayanan kesehatan khusus untuk anak-anak.',
        ]);
    }
}