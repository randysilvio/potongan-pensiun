<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PotonganTahunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar pegawai dengan paginasi dan filter.
     * Juga mengirimkan daftar semua pegawai untuk modal cetak.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $tahun = $request->input('tahun', date('Y'));

        $query = Pegawai::query();

        if ($search) {
            $query->where('nama_pegawai', 'like', '%' . $search . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }

        $pegawais = $query->with(['potonganTahunan' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        }])->orderBy('nama_pegawai', 'asc')->paginate(10);
        
        // Mengambil semua data pegawai untuk mengisi dropdown di modal cetak
        $all_pegawai = Pegawai::orderBy('nama_pegawai', 'asc')->get();
        
        return view('pegawais.index', compact('pegawais', 'all_pegawai', 'search', 'status', 'tahun'));
    }

    /**
     * Menampilkan form untuk membuat data pegawai baru.
     */
    public function create()
    {
        return view('pegawais.create');
    }

    /**
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string',
        ]);
        Pegawai::create($request->all());
        return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk menambah/mengedit data potongan.
     */
    public function createPotongan(Request $request, Pegawai $pegawai)
    {
        $tahun = $request->input('tahun', date('Y'));
        $potongan = $pegawai->potonganTahunan()->firstOrNew(['tahun' => $tahun]);
        return view('pegawais.create-potongan', compact('pegawai', 'potongan', 'tahun'));
    }

    /**
     * Menyimpan data potongan ke database.
     */
    public function storePotongan(Request $request, Pegawai $pegawai)
    {
        $validationRules = ['tahun' => 'required|numeric|min:2000'];
        $bulan_kolom = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        foreach ($bulan_kolom as $bulan) {
            $validationRules['potongan_' . $bulan] = 'nullable|numeric|min:0';
        }
        $request->validate($validationRules);

        $potongan = $pegawai->potonganTahunan()->firstOrNew(['tahun' => $request->input('tahun')]);
        $potongan->fill($request->all());
        $potongan->save();
        return redirect()->route('pegawais.index', ['tahun' => $request->input('tahun')])->with('success', 'Data potongan berhasil disimpan.');
    }
    
    /**
     * Menampilkan form untuk mengedit data pegawai dan potongan.
     */
    public function edit(Pegawai $pegawai, Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $potongan = $pegawai->potonganTahunan()->where('tahun', '>=', $tahun)->first() ?? new PotonganTahunan();
        return view('pegawais.edit', compact('pegawai', 'potongan', 'tahun'));
    }

    /**
     * Memperbarui data potongan di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validationRules = [];
        $bulan_kolom = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        foreach ($bulan_kolom as $bulan) {
            $validationRules['potongan_' . $bulan] = 'nullable|numeric|min:0';
        }
        $request->validate($validationRules);

        $potongan = $pegawai->potonganTahunan()->firstOrNew(['tahun' => $request->input('tahun')]);
        $potongan->fill($request->all());
        $potongan->save();
        return redirect()->route('pegawais.index', ['tahun' => $request->input('tahun')])->with('success', 'Data potongan berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    /**
     * Menangani semua permintaan cetak dari modal fleksibel.
     */
    public function cetakFleksibel(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:keseluruhan,personal',
            'pegawai_id' => 'required_if:jenis_laporan,personal|exists:pegawais,id',
            'tahun_mulai' => 'required|numeric|min:2000',
            'tahun_akhir' => 'required|numeric|min:2000|gte:tahun_mulai',
        ]);

        $jenis_laporan = $request->input('jenis_laporan');
        $tahun_mulai = $request->input('tahun_mulai');
        $tahun_akhir = $request->input('tahun_akhir');

        // Mengambil data setting tanda tangan dari session
        $settings = Session::get('cetak_settings', [
            'tempat' => 'Jayapura',
            'tanggal' => now()->format('Y-m-d'),
            'petugas' => 'NAMA PETUGAS',
            'jabatan' => 'Jabatan'
        ]);

        if ($jenis_laporan == 'keseluruhan') {
            // Logika untuk Laporan Potongan Keseluruhan
            $pegawais = Pegawai::with(['potonganTahunan' => function ($query) use ($tahun_mulai, $tahun_akhir) {
                $query->whereBetween('tahun', [$tahun_mulai, $tahun_akhir]);
            }])->orderBy('nama_pegawai', 'asc')->get();

            $data = compact('pegawais', 'tahun_mulai', 'tahun_akhir', 'settings');
            $pdf = Pdf::loadView('pegawais.cetak', $data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream("laporan-potongan-keseluruhan-{$tahun_mulai}-{$tahun_akhir}.pdf");

        } elseif ($jenis_laporan == 'personal') {
            // Logika untuk Laporan Potongan Personal
            $pegawai = Pegawai::with(['potonganTahunan' => function ($query) use ($tahun_mulai, $tahun_akhir) {
                $query->whereBetween('tahun', [$tahun_mulai, $tahun_akhir])->orderBy('tahun', 'asc');
            }])->findOrFail($request->input('pegawai_id'));

            $data = compact('pegawai', 'tahun_mulai', 'tahun_akhir', 'settings');
            $pdf = Pdf::loadView('pegawais.cetak-personal-range', $data); // Menggunakan view baru
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream("laporan-personal-{$pegawai->nama_pegawai}-{$tahun_mulai}-{$tahun_akhir}.pdf");
        }
    }

    /**
     * Memperbarui pengaturan tanda tangan untuk dicetak.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'tahun' => 'required|numeric',
            'tempat' => 'required|string',
            'tanggal' => 'required|date',
            'petugas' => 'required|string',
            'jabatan' => 'required|string',
        ]);
        Session::put('cetak_settings', $request->only(['tahun', 'tempat', 'tanggal', 'petugas', 'jabatan']));
        return redirect()->route('pegawais.index', ['tahun' => $request->input('tahun')])->with('success', 'Pengaturan cetak berhasil disimpan.');
    }
}