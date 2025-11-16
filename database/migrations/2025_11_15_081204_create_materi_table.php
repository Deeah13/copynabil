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
    Schema::create('materi', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('file_path')->nullable(); // Path file di storage
        $table->string('link_url')->nullable();   // Link eksternal
        
        // Relasi ke Jadwal Sesi
        $table->foreignId('sesi_id')
              ->constrained('jadwal_sesi')
              ->onDelete('cascade');
              
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
