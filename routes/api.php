<?php

use App\Http\Controllers\MusicaController;
use Illuminate\Support\Facades\Route;

Route::get('/musicas', [MusicaController::class, 'index']);
Route::post('/musicas', [MusicaController::class, 'store']);
