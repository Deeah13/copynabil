<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ensureJadwalSoftDeleteColumn();
    }

    private function ensureJadwalSoftDeleteColumn(): void
    {
        if (!Schema::hasTable('jadwal_sesi')) {
            return;
        }

        if (!Schema::hasColumn('jadwal_sesi', 'deleted_at')) {
            Schema::table('jadwal_sesi', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }
}
