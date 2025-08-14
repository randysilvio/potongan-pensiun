<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $query = Pegawai::query();

        if ($search) {
            $query->where('nama_lengkap', 'like', '%' . $search . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }

        $pegawais = $query->orderBy('nama_lengkap', 'asc')->paginate(10);
        return view('pegawais.index', compact('pegawais', 'search', 'status'));
    }

    public function create()
    {
        return view('pegawais.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'status' => 'required|string',
            'potongan_*' => 'nullable|numeric|min:0',
        ]);
        
        Pegawai::create($request->all());
        
        return redirect()->route('pegawais.index')
                         ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('pegawais.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'status' => 'required|string',
            'potongan_*' => 'nullable|numeric|min:0',
        ]);
        $pegawai->update($request->all());
        return redirect()->route('pegawais.index')
                         ->with('success', 'Data pegawai berhasil diperbarui.');
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
        $query = Pegawai::query();
        if ($search) {
            $query->where('nama_lengkap', 'like', '%' . $search . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }
        $pegawais = $query->orderBy('nama_lengkap', 'asc')->get();
        
        $settings = Session::get('cetak_settings', [
            'tahun' => \Carbon\Carbon::now()->year,
            'tempat' => 'Jayapura',
            'tanggal' => \Carbon\Carbon::now()->format('Y-m-d'),
            'petugas' => 'NAMA PETUGAS',
            'jabatan' => 'Jabatan'
        ]);

        return view('pegawais.cetak', compact('pegawais', 'search', 'status', 'settings'));
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

        return redirect()->route('pegawais.index')->with('success', 'Pengaturan cetak berhasil disimpan.');
    }
}