<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_sesi', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('waktu_selesai');
            $table->unsignedInteger('jumlah_peserta')->nullable()->after('lokasi');
            $table->string('status')->default('Akan Datang')->after('jumlah_peserta');
            $table->string('topik_pembelajaran')->nullable()->after('status');
        });

        Schema::table('materi', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('judul');
            $table->string('status')->default('Terunggah')->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'status']);
        });

        Schema::table('jadwal_sesi', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'jumlah_peserta', 'status', 'topik_pembelajaran']);
        });
    }
};
