<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h2>Edit Data: {{ $pegawai->nama_lengkap }}</h2>
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

        <form action="{{ route('pegawais.update', $pegawai->id) }}" method="POST">
            @csrf
            @method('PUT')
             <div class="card">
                <div class="card-header">Detail Pegawai</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Aktif" {{ old('status', $pegawai->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $pegawai->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Rincian Potongan Bulanan (Rp)</div>
                <div class="card-body">
                     <div class="row">
                        @php $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp
                        @foreach ($bulan as $b)
                            @php $nama_kolom = 'potongan_' . strtolower($b); @endphp
                            <div class="col-md-4 col-lg-3 mb-3">
                                <label for="{{ $nama_kolom }}" class="form-label">Potongan {{ $b }}</label>
                                <input type="number" step="any" class="form-control" id="{{ $nama_kolom }}" name="{{ $nama_kolom }}" value="{{ old($nama_kolom, $pegawai->$nama_kolom) }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('pegawais.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>