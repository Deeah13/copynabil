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
    Schema::create('jadwal_sesi', function (Blueprint $table) {
        $table->id();
        $table->string('topik'); // Misal: Matematika Dasar
        $table->text('deskripsi')->nullable();
        $table->dateTime('waktu_mulai');
        $table->dateTime('waktu_selesai')->nullable(); // Opsional
        
        // Relasi ke Guru (users)
        $table->foreignId('guru_id')
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
        Schema::dropIfExists('jadwal_sesi');
    }
};
