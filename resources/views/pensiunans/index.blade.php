<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Pensiunan Pendeta GPI Papua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .table td, .table th { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">📋 Database Potongan Pensiunan Pendeta GPI Papua</h1>
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('pensiunans.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ $search ?? '' }}">
                        <button class="btn btn-secondary" type="submit"><i class="bi bi-search"></i> Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('pensiunans.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
                <a href="{{ route('pensiunans.cetak', ['search' => $search ?? '']) }}" target="_blank" class="btn btn-outline-success">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Rincian Potongan</th>
                        <th scope="col">Total (Rp)</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensiunans as $pensiunan)
                        <tr>
                            <td>{{ $loop->iteration + $pensiunans->firstItem() - 1 }}</td>
                            <td>{{ $pensiunan->nama_lengkap }}</td>
                            <td>
                                @php
                                    $bulan_terpotong = []; $total_potongan = 0;
                                    $daftar_bulan = [
                                        'Jan' => 'potongan_januari', 'Feb' => 'potongan_februari', 'Mar' => 'potongan_maret',
                                        'Apr' => 'potongan_april', 'Mei' => 'potongan_mei', 'Jun' => 'potongan_juni',
                                        'Jul' => 'potongan_juli', 'Ags' => 'potongan_agustus', 'Sep' => 'potongan_september',
                                        'Okt' => 'potongan_oktober', 'Nov' => 'potongan_november', 'Des' => 'potongan_desember',
                                    ];
                                    foreach ($daftar_bulan as $singkatan => $nama_kolom) {
                                        if ($pensiunan->$nama_kolom > 0) { $bulan_terpotong[] = $singkatan; }
                                        $total_potongan += $pensiunan->$nama_kolom;
                                    }
                                @endphp
                                @forelse ($bulan_terpotong as $bulan)
                                    <span class="badge bg-info">{{ $bulan }}</span>
                                @empty
                                    <span class="badge bg-secondary">Belum ada</span>
                                @endforelse
                            </td>
                            <td>{{ number_format($total_potongan, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $pensiunan->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $pensiunan->status }}</span>
                            </td>
                            <td>
                                <form onsubmit="return confirm('Apakah Anda Yakin ingin menghapus data ini?');" action="{{ route('pensiunans.destroy', $pensiunan->id) }}" method="POST">
                                    <a href="{{ route('pensiunans.edit', $pensiunan->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $pensiunans->appends(['search' => $search ?? ''])->links() }}
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>