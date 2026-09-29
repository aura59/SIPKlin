<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $doctors = [
        [
            'email' => 'neo@gmail.com',
            'nama' => 'Dr. Hau Mingga Pradana',
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
            'poli' => 'Poli Umum',
        ],
        [
            'email' => 'tian@gmail.com',
            'nama' => 'Dr. Tiara Xiandra',
            'spesialis' => 'Gigi',
            'no_telepon' => '083873925822',
            'poli' => 'Poli Gigi',
        ],
        [
            'email' => 'lulu@gmail.com',
            'nama' => 'Dr. Luna Yusvara',
            'spesialis' => 'Anak',
            'no_telepon' => '083813054300',
            'poli' => 'Poli Anak',
        ],
        [
            'email' => 'bella@gmail.com',
            'nama' => 'Dr. Bella Kaila',
            'spesialis' => 'Mata',
            'no_telepon' => '081234567893',
            'poli' => 'Poli Mata',
        ],
        [
            'email' => 'yuyu@gmail.com',
            'nama' => 'Dr. Yura Shavina',
            'spesialis' => 'Kandungan',
            'no_telepon' => '081234567895',
            'poli' => 'Poli Kandungan',
        ],
        [
            'email' => 'luqi@gmail.com',
            'nama' => 'Dr. Luki Ardhana',
            'spesialis' => 'Penyakit Dalam',
            'no_telepon' => '081234567896',
            'poli' => 'Poli Penyakit Dalam',
        ],
        [
            'email' => 'Dena@gmail.com',
            'nama' => 'Dr. Dena Anesya',
            'spesialis' => 'THT',
            'no_telepon' => '081234567898',
            'poli' => 'Poli THT',
        ],
        [
            'email' => 'Chandra@gmail.com',
            'nama' => 'Dr. Chandra Wasena',
            'spesialis' => 'Kulit dan Kelamin',
            'no_telepon' => '081234567899',
            'poli' => 'Poli Kulit dan Kelamin',
        ],
        [
            'email' => 'heyu@gmail.com',
            'nama' => 'Dr. Heyu Adinata',
            'spesialis' => 'Saraf',
            'no_telepon' => '081234567801',
            'poli' => 'Poli Saraf',
        ],
        [
            'email' => 'ryan@gmail.com',
            'nama' => 'Dr. Dion Yudhistira',
            'spesialis' => 'Bedah',
            'no_telepon' => '081234567802',
            'poli' => 'Poli Bedah',
        ],
    ];

        foreach ($doctors as $data) {
            $userDokter = User::where('email', $data['email'])->first();

            if (!$userDokter) {
                $userDokter = User::create([
                    'name' => $data['nama'],
                    'email' => $data['email'],
                    'password' => Hash::make('12345678'),
                    'role' => 'dokter',
                ]);
            }

            $department = Department::where('name', $data['poli'])->first();

            Doctor::create([
                'user_id' => $userDokter->id,
                'department_id' => $department->id,
                'nama' => $data['nama'],
                'spesialis' => $data['spesialis'],
                'no_telepon' => $data['no_telepon'],
            ]);
        }
    }
}
