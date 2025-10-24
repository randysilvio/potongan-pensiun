<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Potongan Dana Pensiun Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style> .table td, .table th { vertical-align: middle; } </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">📋 Data Potongan Dana Pensiun Pegawai GPI Papua</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Dashboard
            </a>
        </div>
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="mb-4">
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#settingsCollapse" aria-expanded="false" aria-controls="settingsCollapse">
                <i class="bi bi-gear"></i> Pengaturan Tanda Tangan Laporan
            </button>
            <div class="collapse mt-3" id="settingsCollapse">
                <div class="card card-body">
                    <form action="{{ route('pegawais.updateSettings') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="tahun" class="form-label">Tahun Periode</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" value="{{ session('cetak_settings.tahun', \Carbon\Carbon::now()->year) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tempat" class="form-label">Tempat</label>
                                <input type="text" name="tempat" id="tempat" class="form-control" value="{{ session('cetak_settings.tempat', 'Jayapura') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ session('cetak_settings.tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="petugas" class="form-label">Nama Petugas</label>
                                <input type="text" name="petugas" id="petugas" class="form-control" value="{{ session('cetak_settings.petugas', 'NAMA PETUGAS') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ session('cetak_settings.jabatan', 'Jabatan') }}">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Simpan Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-2">
                <form id="search-form" action="{{ route('pegawais.index') }}" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        <input type="text" name="search" id="search-input" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6 text-md-end mb-2">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('pegawais.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Pegawai</a>
                    
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cetakFleksibelModal">
                        <i class="bi bi-printer-fill"></i> Cetak Laporan Fleksibel
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-2">
                <form id="filter-form" action="{{ route('pegawais.index') }}" method="GET">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                    <div class="input-group">
                        <label class="input-group-text" for="status-filter">Filter Status</label>
                        <select class="form-select" id="status-filter" name="status">
                            <option value="">Semua</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6 mb-2 text-md-end">
                <form id="tahun-form" action="{{ route('pegawais.index') }}" method="GET">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <div class="input-group">
                        <label class="input-group-text bg-info fw-bold" for="tahun-filter">Filter Tahun</label>
                        <select class="form-select" id="tahun-filter" name="tahun" onchange="this.form.submit()">
                            @for ($y = date('Y'); $y >= 2000; $y--)
                                <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Total Potongan (Rp)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $pegawai)
                        @php
                            $total_potongan = 0;
                            $potongan_data = $pegawai->potonganTahunan->first();
                            if ($potongan_data) {
                                $bulan_kolom = ['potongan_januari', 'potongan_februari', 'potongan_maret', 'potongan_april', 'potongan_mei', 'potongan_juni', 'potongan_juli', 'potongan_agustus', 'potongan_september', 'potongan_oktober', 'potongan_november', 'potongan_desember'];
                                foreach ($bulan_kolom as $kolom) {
                                    $total_potongan += $potongan_data->$kolom;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration + $pegawais->firstItem() - 1 }}</td>
                            <td>{{ $pegawai->nama_pegawai }}</td>
                            <td>{{ number_format($total_potongan, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $pegawai->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $pegawai->status }}</span></td>
                            <td>
                                <form onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('pegawais.destroy', $pegawai->id) }}" method="POST">
                                    @if($potongan_data)
                                    <a href="{{ route('pegawais.edit', ['pegawai' => $pegawai->id, 'tahun' => request('tahun')]) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    @else
                                    <a href="{{ route('pegawais.createPotongan', ['pegawai' => $pegawai->id, 'tahun' => request('tahun')]) }}" class="btn btn-success btn-sm" title="Tambah Potongan"><i class="bi bi-plus-square"></i></a>
                                    @endif
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">{{ $pegawais->appends(['search' => request('search'), 'status' => request('status'), 'tahun' => request('tahun')])->links() }}</div>
    </div>

    <div class="modal fade" id="cetakFleksibelModal" tabindex="-1" aria-labelledby="cetakFleksibelModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="cetakFleksibelModalLabel">Pengaturan Cetak Laporan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('laporan.cetakFleksibel') }}" method="POST" target="_blank">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="jenis_laporan" class="form-label">Jenis Laporan</label>
                <select class="form-select" name="jenis_laporan" id="jenis_laporan" required>
                  <option value="keseluruhan">Rekap Potongan Keseluruhan</option>
                  <option value="personal">Rekap Potongan Personal</option>
                </select>
              </div>
              <div class="mb-3" id="pegawai-select-container" style="display: none;">
                <label for="pegawai_id" class="form-label">Pilih Pegawai</label>
                
                <select class="form-select" name="pegawai_id" id="pegawai_id">
                  <option value="" disabled selected>-- Pilih Nama Pegawai --</option>
                  @foreach($all_pegawai as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_pegawai }}</option>
                  @endforeach
                </select>
                </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                  
                  <input type="number" class="form-control" name="tahun_mulai" id="tahun_mulai" value="2000" required>
                  </div>
                <div class="col-md-6 mb-3">
                  <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                  <input type="number" class="form-control" name="tahun_akhir" id="tahun_akhir" value="{{ date('Y') }}" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success"><i class="bi bi-printer"></i> Cetak Sekarang</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('search-input')?.addEventListener('input', function() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => document.getElementById('search-form').submit(), 800);
        });

        document.getElementById('status-filter')?.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        // Script untuk menampilkan/menyembunyikan dropdown pegawai
        document.getElementById('jenis_laporan').addEventListener('change', function() {
            const pegawaiContainer = document.getElementById('pegawai-select-container');
            const pegawaiSelect = document.getElementById('pegawai_id');
            if (this.value === 'personal') {
                pegawaiContainer.style.display = 'block';
                pegawaiSelect.setAttribute('required', 'required');
            } else {
                pegawaiContainer.style.display = 'none';
                pegawaiSelect.removeAttribute('required');
                pegawaiSelect.value = ''; // Reset pilihan jika disembunyikan
            }
        });
    </script>
</body>
</html>
