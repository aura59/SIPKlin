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
            'avatar' => 'img/profile/yeonjun.jpg',
        ]);

        User::create([
            'name' => 'Dr. Hau Mingga Pradana',
            'email' => 'neo@gmail.com',
            'password' => Hash::make('bojai123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/download (23).jpg',
        ]);

         User::create([
            'name' => 'Dr. Luna Yusvara',
            'email' => 'lulu@gmail.com',
            'password' => Hash::make('irene123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/download (30).jpg',
        ]);

         User::create([
            'name' => 'Dr. Tiara Xiandra',
            'email' => 'tian@gmail.com',
            'password' => Hash::make('changyu123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/download (31).jpg',
        ]);

        User::create([
            'name' => 'Dr. Bella Kaila',
            'email' => 'bella@gmail.com',
            'password' => Hash::make('bailu123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/bailu.jpg',
        ]);

        User::create([
            'name' => 'Dr. Yura Shavina',
            'email' => 'yuyu@gmail.com',
            'password' => Hash::make('estheryu'),
            'role' => 'dokter',
            'avatar' => 'img/profile/esther.jpg',
        ]);

        User::create([
            'name' => 'Dr. Luki Ardhana',
            'email' => 'luqi@gmail.com',
            'password' => Hash::make('buxiu123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/luqi.jpg',
        ]);

        User::create([
            'name' => 'Dr. Dena Anesya',
            'email' => 'Dena@gmail.com',
            'password' => Hash::make('dengenxi'),
            'role' => 'dokter',
            'avatar' => 'img/profile/enxi.jpg',
        ]);

        User::create([
            'name' => 'Dr. Chandra Wasena',
            'email' => 'Chandra@gmail.com',
            'password' => Hash::make('huasen123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/chang.jpg',
        ]);

        User::create([
            'name' => 'Dr. Heyu Adinata',
            'email' => 'heyu@gmail.com',
            'password' => Hash::make('heyu123'),
            'role' => 'dokter',
            'avatar' => 'img/profile/heyu.jpg',
        ]);

        User::create([
            'name' => 'Dr. Dion Yudhistira',
            'email' => 'ryan@gmail.com',
            'password' => Hash::make('dingyuxi'),
            'role' => 'dokter',
            'avatar' => 'img/profile/ryan.jpg',
        ]);
    }
}