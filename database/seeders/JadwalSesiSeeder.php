<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\JadwalSesi;
use Carbon\Carbon;

class JadwalSesiSeeder extends Seeder
{
    public function run(): void
    {
        $roleGuru = Role::where('nama_role', 'Guru')->first();

        // 1. Buat Guru (Pak Fakhri)
        $pakFakhri = User::create([
            'nama' => 'Pak Fakhri',
            'email' => 'fakhri@terminalpintar.com',
            'password' => bcrypt('password'),
            'role_id' => $roleGuru->id
        ]);
        
        // Buat Guru Lain (Ibu Ica)
        $buIca = User::create([
            'nama' => 'Ibu Ica',
            'email' => 'ica@terminalpintar.com',
            'password' => bcrypt('password'),
            'role_id' => $roleGuru->id
        ]);

        // 2. Buat Jadwal MASA LALU (Selesai)
        JadwalSesi::create([
            'topik' => 'Matematika Dasar',
            'deskripsi' => 'Belajar perkalian dan pembagian dasar.',
            'waktu_mulai' => Carbon::now()->subDays(2)->setHour(8)->setMinute(0), // 2 hari lalu
            'waktu_selesai' => Carbon::now()->subDays(2)->setHour(10)->setMinute(0),
            'guru_id' => $pakFakhri->id
        ]);

        JadwalSesi::create([
            'topik' => 'Bahasa Inggris - Vocabulary',
            'deskripsi' => 'Mengenal kata benda di sekitar sekolah.',
            'waktu_mulai' => Carbon::now()->subDays(1)->setHour(9)->setMinute(0), // Kemarin
            'waktu_selesai' => Carbon::now()->subDays(1)->setHour(11)->setMinute(0),
            'guru_id' => $buIca->id
        ]);

        // 3. Buat Jadwal MASA DEPAN (Akan Datang) - Sesuai Mockup
        JadwalSesi::create([
            'topik' => 'Matematika Lanjutan',
            'deskripsi' => 'Latihan soal cerita matematika.',
            'waktu_mulai' => Carbon::now()->addDays(1)->setHour(9)->setMinute(0), // Besok
            'waktu_selesai' => Carbon::now()->addDays(1)->setHour(11)->setMinute(0),
            'guru_id' => $pakFakhri->id
        ]);

        JadwalSesi::create([
            'topik' => 'Belajar Memilah Sampah',
            'deskripsi' => 'Praktek langsung memilah sampah organik dan anorganik.',
            'waktu_mulai' => Carbon::now()->addDays(2)->setHour(9)->setMinute(0), // Lusa
            'waktu_selesai' => Carbon::now()->addDays(2)->setHour(11)->setMinute(0),
            'guru_id' => $pakFakhri->id
        ]);
    }
}