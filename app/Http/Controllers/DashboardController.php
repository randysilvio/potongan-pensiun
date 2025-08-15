<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PotonganTahunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_pegawai = Pegawai::count();

        // Menghitung total semua potongan dari semua pegawai untuk tahun berjalan
        $total_potongan_tahunan = PotonganTahunan::where('tahun', date('Y'))->sum(
            DB::raw('potongan_januari + potongan_februari + potongan_maret + potongan_april + 
                     potongan_mei + potongan_juni + potongan_juli + potongan_agustus + 
                     potongan_september + potongan_oktober + potongan_november + potongan_desember')
        );

        return view('dashboard', [
            'jumlah_pegawai' => $jumlah_pegawai,
            'total_potongan_tahunan' => $total_potongan_tahunan
        ]);
    }
}