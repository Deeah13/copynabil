<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('kehadiran', function (Blueprint $table) {
        $table->id();
        $table->string('status'); // Hadir, Izin, Sakit, Alpha
        
        // Relasi ke Jadwal Sesi
        $table->foreignId('sesi_id')
              ->constrained('jadwal_sesi')
              ->onDelete('cascade');

        // Relasi ke Siswa
        $table->foreignId('siswa_id')
              ->constrained('siswa')
              ->onDelete('cascade');
              
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
