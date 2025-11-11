<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita; // <-- TAMBAHKAN INI
use App\Models\User;   // <-- TAMBAHKAN INI

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@terminalpintar.com')->first();

        Berita::create([
            'judul' => 'Workshop Coding untuk Anak',
            'konten' => 'Belajar dasar-dasar programming dengan cara yang menyenangkan.',
            'gambar' => 'path/to/image_coding.jpg',
            'penulis_id' => $admin->id
        ]);

        Berita::create([
            'judul' => 'Kelas Bahasa Interaktif',
            'konten' => 'Mengenalkan bahasa Inggris dengan metode storytelling dan games.',
            'gambar' => 'path/to/image_bahasa.jpg',
            'penulis_id' => $admin->id
        ]);

        Berita::create([
            'judul' => 'Perpustakaan Mini Kini Dibuka',
            'konten' => 'Anak-anak kini memiliki perpustakaan mini dengan 200+ buku bacaan.',
            'gambar' => 'path/to/image_perpustakaan.jpg',
            'penulis_id' => $admin->id
        ]);
    }
}