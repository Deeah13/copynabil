<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatatanGuru;
use App\Models\Siswa;
use App\Models\User;

class CatatanGuruSeeder extends Seeder
{
    public function run(): void
    {
        $hanif = Siswa::where('nama_lengkap', 'Hanif Jawahir')->first();
        $pakFakhri = User::where('nama', 'Pak Fakhri')->first();
        $buIca = User::where('nama', 'Ibu Ica')->first();

        if ($hanif && $pakFakhri) {
            CatatanGuru::create([
                'catatan' => 'Hanif sudah bisa menghitung perkalian sederhana. Ia tadi usil menjahili temannya hingga menangis, mohon dinasihati di rumah ya Bu.',
                'siswa_id' => $hanif->id,
                'guru_id' => $pakFakhri->id
            ]);
        }

        if ($hanif && $buIca) {
            CatatanGuru::create([
                'catatan' => 'Hanif sangat aktif dalam sesi mengenal kata benda (Vocabulary). Hafalannya sangat kuat.',
                'siswa_id' => $hanif->id,
                'guru_id' => $buIca->id
            ]);
        }
    }
}