<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PotonganTahunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data dinamis.
     */
    public function index()
    {
        // Menghitung jumlah pegawai dari tabel 'pegawais'
        $jumlah_pegawai = Pegawai::count();

        // Menghitung total semua potongan dari tabel 'potongan_tahunan' untuk tahun berjalan
        $total_potongan_tahunan = PotonganTahunan::where('tahun', date('Y'))->sum(
            DB::raw('potongan_januari + potongan_februari + potongan_maret + potongan_april + 
                     potongan_mei + potongan_juni + potongan_juli + potongan_agustus + 
                     potongan_september + potongan_oktober + potongan_november + potongan_desember')
        );

        // Mengirim data ke view dashboard
        return view('dashboard', [
            'jumlah_pegawai' => $jumlah_pegawai,
            'total_potongan_tahunan' => $total_potongan_tahunan
        ]);
    }
}