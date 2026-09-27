<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dr. Hau Mingga Pradana',
            'email' => 'neo@gmail.com',
            'password' => Hash::make('bojai123'),
            'role' => 'dokter',
        ]);

         User::create([
            'name' => 'Dr. Luna Yusvara',
            'email' => 'lulu@gmail.com',
            'password' => Hash::make('irene123'),
            'role' => 'dokter',
        ]);

         User::create([
            'name' => 'Dr. Tiara Xiandra',
            'email' => 'tian@gmail.com',
            'password' => Hash::make('changyu123'),
            'role' => 'dokter',
        ]);

        $doctors = [
            'Dr. Zayn Lingga',
            'Dr. Bella Kaila',
            'Dr. Miona Zhanggara',
            'Dr. Yura Shavina',
            'Dr. Luki Ardhana',
            'Dr. Yoren Zayandra',
            'Dr. Dena Anesya',
            'Dr. Chandra Wasena',
            'Dr. Yuna Yutania',
            'Dr. Heyu Adinata',
            'Dr. Gavin Juna',
            'Dr. Dion Yudhistira',
        ];

        foreach ($doctors as $key => $doctor) {
            User::create([
                'name' => $doctor,
                'email' => 'dokter' . ($key + 1) . '@sipklin.com',
                'password' => Hash::make('password'),
                'role' => 'dokter',
            ]);
        }
    }
}