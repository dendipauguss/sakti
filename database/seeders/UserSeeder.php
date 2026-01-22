<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('password_admin'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Pegawai',
            'email' => 'pegawai@gmail.com',
            'username' => 'pegawai',
            'password' => Hash::make('password_pegawai'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Ketua Tim',
            'email' => 'ketuatim@gmail.com',
            'username' => 'ketuatim',
            'password' => Hash::make('password_ketuatim'),
            'role' => 'ketua_tim'
        ]);

        User::create([
            'nama' => 'Dendi Paugus Sukmaya',
            'email' => 'dendipauguss1111@gmail.com',
            'username' => 'dendipauguss',
            'password' => Hash::make('dendi_gamtenk'),
            'role' => 'admin'
        ]);
    }
}
