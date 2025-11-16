<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    protected $guarded = ['id'];

    // Tambahkan ini
    public function jadwalSesi()
    {
        return $this->belongsTo(JadwalSesi::class, 'jadwal_sesi_id');
    }
}