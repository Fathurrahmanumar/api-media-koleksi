<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

// CRUD Media (index, show, store, update, destroy)
// parameters() wajib: Laravel mengubah "media" menjadi "medium" saat singularize,
// sehingga route model binding {media} akan gagal tanpa ini.
Route::apiResource('media', MediaController::class)
    ->parameters(['media' => 'media']);

// Pengguna
Route::apiResource('pengguna', PenggunaController::class)
    ->only(['index', 'show', 'store'])
    ->parameters(['pengguna' => 'pengguna']);

// Koleksi pengguna (custom action yang mengubah relasi pivot)
Route::get('pengguna/{pengguna}/koleksi', [PenggunaController::class, 'koleksi']);
Route::post('pengguna/{pengguna}/koleksi', [PenggunaController::class, 'tambahMedia']);
Route::delete('pengguna/{pengguna}/koleksi/{media}', [PenggunaController::class, 'hapusMedia']);
