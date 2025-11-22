<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JadwalSesi extends Model
{
    protected $table = 'jadwal_sesi';
    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // --- PERBAIKAN DI SINI ---
    public function materi()
    {
        // Ubah 'jadwal_sesi_id' menjadi 'sesi_id' sesuai database Anda
        return $this->hasMany(Materi::class, 'sesi_id');
    }
}