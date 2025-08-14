<?php

namespace App\Http\Controllers;

use App\Models\Pensiunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- PENTING: Import DB Facade

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data dinamis.
     */
    public function index()
    {
        // Menghitung jumlah pensiunan
        $jumlah_pensiunan = Pensiunan::count();

        // Menghitung total semua potongan dari semua pensiunan
        $total_potongan_tahunan = Pensiunan::sum(
            DB::raw('potongan_januari + potongan_februari + potongan_maret + potongan_april + 
                     potongan_mei + potongan_juni + potongan_juli + potongan_agustus + 
                     potongan_september + potongan_oktober + potongan_november + potongan_desember')
        );

        // Mengirim data ke view dashboard
        return view('dashboard', [
            'jumlah_pensiunan' => $jumlah_pensiunan,
            'total_potongan_tahunan' => $total_potongan_tahunan
        ]);
    }
}