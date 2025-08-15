<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PotonganTahunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
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
        
        return view('pegawais.index', compact('pegawais', 'search', 'status', 'tahun'));
    }

    public function create()
    {
        return view('pegawais.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string',
        ]);

        Pegawai::create($request->all());

        return redirect()->route('pegawais.index')
                         ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function createPotongan(Request $request, Pegawai $pegawai)
    {
        $tahun = $request->input('tahun', date('Y'));
        $potongan = $pegawai->potonganTahunan()->firstOrNew(['tahun' => $tahun]);
        
        return view('pegawais.create-potongan', compact('pegawai', 'potongan', 'tahun'));
    }

    public function storePotongan(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'tahun' => 'required|numeric|min:2000',
            'potongan_januari' => 'nullable|numeric|min:0',
            'potongan_februari' => 'nullable|numeric|min:0',
            'potongan_maret' => 'nullable|numeric|min:0',
            'potongan_april' => 'nullable|numeric|min:0',
            'potongan_mei' => 'nullable|numeric|min:0',
            'potongan_juni' => 'nullable|numeric|min:0',
            'potongan_juli' => 'nullable|numeric|min:0',
            'potongan_agustus' => 'nullable|numeric|min:0',
            'potongan_september' => 'nullable|numeric|min:0',
            'potongan_oktober' => 'nullable|numeric|min:0',
            'potongan_november' => 'nullable|numeric|min:0',
            'potongan_desember' => 'nullable|numeric|min:0',
        ]);

        $potongan = $pegawai->potonganTahunan()->firstOrNew(['tahun' => $request->input('tahun')]);
        $potongan->fill($request->all());
        $potongan->save();

        return redirect()->route('pegawais.index', ['tahun' => $request->input('tahun')])
                         ->with('success', 'Data potongan berhasil ditambahkan.');
    }
    
    public function edit(Pegawai $pegawai, Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $potongan = $pegawai->potonganTahunan()->where('tahun', $tahun)->first();
        
        if (!$potongan) {
            $potongan = new PotonganTahunan();
        }
        
        return view('pegawais.edit', compact('pegawai', 'potongan', 'tahun'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'potongan_januari' => 'nullable|numeric|min:0',
            'potongan_februari' => 'nullable|numeric|min:0',
            'potongan_maret' => 'nullable|numeric|min:0',
            'potongan_april' => 'nullable|numeric|min:0',
            'potongan_mei' => 'nullable|numeric|min:0',
            'potongan_juni' => 'nullable|numeric|min:0',
            'potongan_juli' => 'nullable|numeric|min:0',
            'potongan_agustus' => 'nullable|numeric|min:0',
            'potongan_september' => 'nullable|numeric|min:0',
            'potongan_oktober' => 'nullable|numeric|min:0',
            'potongan_november' => 'nullable|numeric|min:0',
            'potongan_desember' => 'nullable|numeric|min:0',
        ]);
        
        $potongan = $pegawai->potonganTahunan()->firstOrNew(['tahun' => $request->input('tahun')]);
        $potongan->fill($request->all());
        $potongan->save();

        return redirect()->route('pegawais.index', ['tahun' => $request->input('tahun')])
                         ->with('success', 'Data potongan berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawais.index')
                         ->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function cetak(Request $request)
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
        }])->orderBy('nama_pegawai', 'asc')->get();
        
        $settings = Session::get('cetak_settings', [
            'tahun' => $tahun,
            'tempat' => 'Jayapura',
            'tanggal' => now()->format('Y-m-d'),
            'petugas' => 'NAMA PETUGAS',
            'jabatan' => 'Jabatan'
        ]);

        $pdf = Pdf::loadView('pegawais.cetak', compact('pegawais', 'search', 'status', 'settings'));
        
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('laporan-pegawai-'.$tahun.'.pdf');
    }

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

        return redirect()->route('pegawais.index', ['tahun' => $request->input('tahun')])
                         ->with('success', 'Pengaturan cetak berhasil disimpan.');
    }
}