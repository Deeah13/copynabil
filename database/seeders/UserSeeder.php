<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;   // <-- TAMBAHKAN INI
use App\Models\Role;   // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Hash; // <-- TAMBAHKAN INI

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('nama_role', 'Admin')->first();
        $guruRole = Role::where('nama_role', 'Guru')->first();

        // Membuat Admin Pengurus, cth: Andi Rahmadi
        User::create([
            'nama' => 'Andi Rahmadi',
            'email' => 'admin@terminalpintar.com',
            'password' => Hash::make('password'), // Ganti password ini
            'role_id' => $adminRole->id
        ]);

        // Membuat Pengajar, cth: Nabila Nurahmi
        User::create([
            'nama' => 'Nabila Nurahmi',
            'email' => 'guru@terminalpintar.com',
            'password' => Hash::make('password'), // Ganti password ini
            'role_id' => $guruRole->id
        ]);
    }
}