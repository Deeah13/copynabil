<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardOrangTuaController; // <--- Pastikan di-import
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\GuruJadwalMateriController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIC (UNTUK TESTING) ---
// Pastikan baris ini ada dan TIDAK dikomentari
Route::get('/dashboard-orang-tua', [DashboardOrangTuaController::class, 'index']);
Route::get('/kegiatan-terbaru', [BeritaController::class, 'getKegiatanTerbaru']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Rute Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rute Dashboard Orang Tua
    // (Kita kembalikan ke dalam middleware agar aman)
    Route::get('/dashboard-orang-tua', [DashboardOrangTuaController::class, 'index']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/catatan-guru-lengkap', [DashboardOrangTuaController::class, 'getAllCatatan']);
    Route::get('/jadwal-lengkap', [DashboardOrangTuaController::class, 'getAllJadwal']); // <--- INI YANG PENTING

    // Rute Guru - Jadwal & Materi
    Route::get('/guru/jadwal-materi', [GuruJadwalMateriController::class, 'index']);
    Route::post('/guru/jadwal', [GuruJadwalMateriController::class, 'store']);
    Route::put('/guru/jadwal/{jadwalSesi}', [GuruJadwalMateriController::class, 'update']);
    Route::post('/guru/jadwal/{jadwalSesi}/materi', [GuruJadwalMateriController::class, 'storeMaterial']);
    Route::put('/guru/materi/{materi}', [GuruJadwalMateriController::class, 'updateMaterial']);
});