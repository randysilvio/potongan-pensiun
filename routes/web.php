<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController; // <-- Ubah ke PegawaiController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Grup rute yang hanya bisa diakses setelah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/pegawai/settings', [PegawaiController::class, 'updateSettings'])->name('pegawais.updateSettings');
    // Definisikan rute untuk cetak SEBELUM Route::resource
    Route::get('pegawais/cetak', [PegawaiController::class, 'cetak'])->name('pegawais.cetak');
    
    // Rute untuk data pegawai
    Route::resource('pegawais', PegawaiController::class);
});

require __DIR__.'/auth.php';