<?php

namespace App\Http\Controllers;

use App\Models\Pensiunan;
use Illuminate\Http\Request;

class PensiunanController extends Controller
{
    /**
     * Menampilkan daftar semua pensiunan dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('search');

        // Query dasar untuk mengambil data
        $query = Pensiunan::query();

        // Jika ada query pencarian, tambahkan kondisi WHERE
        if ($search) {
            $query->where('nama_lengkap', 'like', '%' . $search . '%');
        }

        // Ambil data dengan pagination dan urutkan berdasarkan nama
        $pensiunans = $query->orderBy('nama_lengkap', 'asc')->paginate(10);

        // Mengirim data dan query pencarian ke view
        return view('pensiunans.index', compact('pensiunans', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('pensiunans.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'status' => 'required|string',
            'potongan_*' => 'nullable|numeric|min:0',
        ]);
        Pensiunan::create($request->all());
        return redirect()->route('pensiunans.index')
                         ->with('success', 'Data pensiunan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(Pensiunan $pensiunan)
    {
        return view('pensiunans.edit', compact('pensiunan'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, Pensiunan $pensiunan)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'status' => 'required|string',
            'potongan_*' => 'nullable|numeric|min:0',
        ]);
        $pensiunan->update($request->all());
        return redirect()->route('pensiunans.index')
                         ->with('success', 'Data pensiunan berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(Pensiunan $pensiunan)
    {
        $pensiunan->delete();
        return redirect()->route('pensiunans.index')
                         ->with('success', 'Data pensiunan berhasil dihapus.');
    }

    /**
     * Menyiapkan data untuk dicetak.
     */
    public function cetak(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('search');

        // Query dasar
        $query = Pensiunan::query();

        // Jika ada query pencarian, filter datanya
        if ($search) {
            $query->where('nama_lengkap', 'like', '%' . $search . '%');
        }

        // Ambil semua data yang cocok (tanpa pagination)
        $pensiunans = $query->orderBy('nama_lengkap', 'asc')->get();

        // Mengirim data ke view cetak
        return view('pensiunans.cetak', compact('pensiunans', 'search'));
    }
}