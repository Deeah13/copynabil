<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalSesi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sesi';
    protected $guarded = ['id'];

    /**
     * Selalu sertakan relasi materi agar akses properti tidak memicu error undefined
     * ketika jadwal dimuat tanpa pemanggilan with() eksplisit.
     */
    protected $with = ['materi'];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class, 'sesi_id');
    }
}
