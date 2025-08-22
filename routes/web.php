<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute Laporan (Cetak Fleksibel)
    Route::post('laporan/cetak-fleksibel', [PegawaiController::class, 'cetakFleksibel'])->name('laporan.cetakFleksibel');
    
    // Rute Pengaturan Tanda Tangan Laporan
    Route::post('pegawais/settings', [PegawaiController::class, 'updateSettings'])->name('pegawais.updateSettings');
    
    // Rute Resourceful untuk Pegawai (CRUD)
    Route::resource('pegawais', PegawaiController::class)->except(['show']);

    // Rute untuk manajemen data potongan
    Route::get('pegawais/{pegawai}/potongan/create', [PegawaiController::class, 'createPotongan'])->name('pegawais.createPotongan');
    Route::post('pegawais/{pegawai}/potongan', [PegawaiController::class, 'storePotongan'])->name('pegawais.storePotongan');
});

require __DIR__.'/auth.php';