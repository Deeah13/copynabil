<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\JadwalSesi;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil sesi matematika (yang dibuat di seeder sebelumnya)
        $sesiMatematika = JadwalSesi::where('topik', 'Matematika Dasar')->first();

        if ($sesiMatematika) {
            Materi::create([
                'judul' => 'Buku Panduan Operasi Pecahan.pdf',
                'file_path' => 'materials/math_guide.pdf', // Path dummy
                'sesi_id' => $sesiMatematika->id
            ]);

            Materi::create([
                'judul' => 'Latihan Soal Perkalian.pdf',
                'file_path' => 'materials/math_exercise.pdf',
                'sesi_id' => $sesiMatematika->id
            ]);
        }
    }
}