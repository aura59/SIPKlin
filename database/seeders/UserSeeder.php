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
            'name' => 'Dr. Hou Minghao',
            'email' => 'bojai@gmail.com',
            'password' => Hash::make('bojai123'),
            'role' => 'dokter',
        ]);

         User::create([
            'name' => 'Dr. Lu Yuxiao',
            'email' => 'xiaoxiao@gmail.com',
            'password' => Hash::make('irene123'),
            'role' => 'dokter',
        ]);

         User::create([
            'name' => 'Dr. Tian Xiwei',
            'email' => 'xiwei@gmail.com',
            'password' => Hash::make('changyu123'),
            'role' => 'dokter',
        ]);

        $doctors = [
            'Dr. Zhang Linghe',
            'Dr. Chen Zheyuan',
            'Dr. Wang Xingyue',
            'Dr. Bai Lu',
            'Dr. Zhao Lusi',
            'Dr. Yu Shuxin',
            'Dr. Wu Lei',
            'Dr. Dylan Wang',
            'Dr. Gong Jun',
            'Dr. Luo Yunxi',
            'Dr. Cheng Yi',
            'Dr. Xiao Zhan',
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