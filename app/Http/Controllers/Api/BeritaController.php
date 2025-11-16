<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Sediakan data kegiatan terbaru untuk LandingPage.
     */
    public function getKegiatanTerbaru()
{
    $dataPalsu = [
        [
            'id' => 1,
            'judul' => 'Workshop Coding untuk Anak',
            'tanggal_kegiatan' => '2025-12-15',
            'deskripsi_singkat' => 'Anak-anak belajar dasar-dasar coding',
            'gambar_url' => asset('images/hero.jpg'),
        ],
        [
            'id' => 2,
            'judul' => 'Kelas Bahasa Interaktif',
            'tanggal_kegiatan' => '2025-12-12',
            'deskripsi_singkat' => 'Sesi pembelajaran bahasa Inggris',
            'gambar_url' => asset('images/dokumentasi2.jpg'),
        ],
        [
            'id' => 3,
            'judul' => 'Perpustakaan Mini Dibuka',
            'tanggal_kegiatan' => '2025-12-31',
            'deskripsi_singkat' => 'Terminal Pintar membuka perpustakaan',
            'gambar_url' => asset('images/dokumentasi.jpg'),
        ],
    ];


        // Kembalikan data sebagai JSON
        return response()->json($dataPalsu);
    }
    
}