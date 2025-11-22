<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_sesi', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_sesi', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_sesi', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_sesi', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
