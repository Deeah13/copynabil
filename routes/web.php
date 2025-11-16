<?php
use App\Http\Controllers\Api\BeritaController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');

