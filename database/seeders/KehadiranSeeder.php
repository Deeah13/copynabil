<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\JadwalSesi;
use Carbon\Carbon;

class KehadiranSeeder extends Seeder
{
    public function run(): void
    {
        $hanif = Siswa::where('nama_lengkap', 'Hanif Jawahir')->first();
        
        // Ambil semua sesi yang SUDAH lewat (masa lalu)
        $sesiSelesai = JadwalSesi::where('waktu_mulai', '<', Carbon::now())->get();

        foreach ($sesiSelesai as $sesi) {
            Kehadiran::create([
                'status' => 'Hadir',
                'sesi_id' => $sesi->id,
                'siswa_id' => $hanif->id
            ]);
        }
    }
}