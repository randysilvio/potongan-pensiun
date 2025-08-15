<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
        return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        // Definisikan rute untuk cetak dan pengaturan cetak
        Route::get('pegawais/cetak', [PegawaiController::class, 'cetak'])->name('pegawais.cetak');
        Route::post('pegawais/settings', [PegawaiController::class, 'updateSettings'])->name('pegawais.updateSettings');

        // Rute untuk tambah data pegawai dasar
        Route::get('pegawais/create', [PegawaiController::class, 'create'])->name('pegawais.create');
        Route::post('pegawais', [PegawaiController::class, 'store'])->name('pegawais.store');
        
        // Rute untuk manajemen data potongan tahunan
        Route::get('pegawais/{pegawai}/potongan/create', [PegawaiController::class, 'createPotongan'])->name('pegawais.createPotongan');
        Route::post('pegawais/{pegawai}/potongan', [PegawaiController::class, 'storePotongan'])->name('pegawais.storePotongan');

        // Rute untuk list, edit, update dan delete
        Route::get('pegawais', [PegawaiController::class, 'index'])->name('pegawais.index');
        Route::get('pegawais/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawais.edit');
        Route::put('pegawais/{pegawai}', [PegawaiController::class, 'update'])->name('pegawais.update');
        Route::delete('pegawais/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawais.destroy');
});

require __DIR__.'/auth.php';