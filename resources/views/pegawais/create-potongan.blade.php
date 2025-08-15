<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Potongan Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h2>Tambah Data Potongan untuk Pegawai: {{ $pegawai->nama_pegawai }}</h2>
        <hr>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pegawais.storePotongan', $pegawai->id) }}" method="POST">
            @csrf
            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            
            <div class="card">
                <div class="card-header">Rincian Potongan untuk Tahun {{ $tahun }}</div>
                <div class="card-body">
                    <div class="row">
                        @php $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp
                        @foreach ($bulan as $b)
                            @php $nama_kolom = 'potongan_' . strtolower($b); @endphp
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label for="{{ $nama_kolom }}" class="form-label">Potongan {{ $b }} (Rp)</label>
                                <input type="number" step="any" class="form-control" id="{{ $nama_kolom }}" name="{{ $nama_kolom }}" value="{{ old($nama_kolom, $potongan->$nama_kolom ?? 0) }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pegawais.index', ['tahun' => $tahun]) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>