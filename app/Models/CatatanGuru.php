<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanGuru extends Model
{
    protected $table = 'catatan_guru';
    protected $guarded = ['id'];

    // Tambahkan ini
    public function guru()
    {
        // Asumsi kolom foreign key di db adalah 'guru_id'
        return $this->belongsTo(User::class, 'guru_id');
    }
}