<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai; // Import model Pegawai
use Illuminate\Support\Facades\DB; // Import DB Facade untuk query
use Carbon\Carbon; // Import Carbon untuk manajemen tanggal

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data dinamis.
     */
    public function index()
    {
        // 1. Mengambil tahun berjalan saat ini
        $tahunIni = Carbon::now()->year;

        // 2. Menghitung jumlah total pegawai
        $totalPegawai = Pegawai::count();

        // 3. Menghitung total akumulasi potongan untuk tahun berjalan
        // Query ini menjumlahkan semua kolom potongan bulanan dari tabel potongan_tahunan
        // yang memiliki tahun yang sama dengan tahun ini.
        $totalPotonganTahunIni = DB::table('potongan_tahunan')
            ->where('tahun', $tahunIni)
            ->sum(DB::raw('
                potongan_januari + potongan_februari + potongan_maret + 
                potongan_april + potongan_mei + potongan_juni + 
                potongan_juli + potongan_agustus + potongan_september + 
                potongan_oktober + potongan_november + potongan_desember
            '));

        // 4. Mengirimkan semua data ke view dashboard
        return view('dashboard', compact(
            'totalPegawai',
            'totalPotonganTahunIni',
            'tahunIni'
        ));
    }
}