<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DropdownController;

#Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);

Route::get('fakultas', [DropdownController::class, 'getFakultas']);
Route::get('jurusan/{fakultas_id}', [DropdownController::class, 'getJurusan']);
Route::get('prodi/{jurusan_id}', [DropdownController::class, 'getProdi']);