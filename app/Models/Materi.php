<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $guarded = ['id'];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalSesi::class, 'sesi_id');
    }
}
