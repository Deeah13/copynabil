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
    Schema::create('siswa', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');
        $table->string('status')->default('Aktif'); // Aktif, Cuti, Lulus
        
        // Relasi ke Orang Tua (users)
        $table->foreignId('orang_tua_id')
              ->constrained('users')
              ->onDelete('cascade');
              
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
