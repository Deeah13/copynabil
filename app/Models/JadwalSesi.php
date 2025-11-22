<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalSesi extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_sesi';
    protected $guarded = ['id'];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

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