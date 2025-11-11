<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Pastikan ini ada

class Berita extends Model
{
    use HasFactory;

    /**
     * Memberitahu model nama tabel yang benar.
     */
    protected $table = 'berita'; // <-- TAMBAHKAN BARIS INI

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = ['judul', 'konten', 'gambar', 'penulis_id']; // <-- Tambahkan ini juga

    /**
     * Relasi ke User (Penulis)
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}