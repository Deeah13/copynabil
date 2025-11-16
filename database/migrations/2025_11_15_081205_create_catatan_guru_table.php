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
    Schema::create('catatan_guru', function (Blueprint $table) {
        $table->id();
        $table->text('catatan');
        
        // Relasi ke Siswa
        $table->foreignId('siswa_id')
              ->constrained('siswa')
              ->onDelete('cascade');

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
        Schema::dropIfExists('catatan_guru');
    }
};
