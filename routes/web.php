<?php

use App\Http\Controllers\MusicaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware('api')->group(function () {
//     Route::get('/top5', [MusicaController::class, 'index']);
//     Route::post('/sugerir', [MusicaController::class, 'store']);
// });

Route::prefix('api')->middleware('api')->group(function () {
    Route::get('/top5', [MusicaController::class, 'index']);
    Route::post('/sugerir', [MusicaController::class, 'store']);
});