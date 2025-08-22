<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Manajemen Dana Pensiun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .stat-card {
            color: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .stat-card h5 {
            font-weight: 300;
        }
        .stat-card .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
        }
        .stat-card .icon {
            position: absolute;
            right: 20px;
            bottom: -20px;
            font-size: 6rem;
            opacity: 0.2;
            transform: rotate(-15deg);
        }
        .bg-primary-gradient {
            background: linear-gradient(45deg, #0d6efd, #5495ff);
        }
        .bg-success-gradient {
            background: linear-gradient(45deg, #198754, #48c385);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">📊 Dashboard</h1>
            {{-- Form Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <div class="alert alert-info">
            Selamat Datang, <strong>{{ Auth::user()->name }}</strong>! Anda login pada {{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }}.
        </div>

        {{-- KARTU STATISTIK DINAMIS --}}
        <div class="row g-4">
            {{-- Kartu Total Pegawai --}}
            <div class="col-md-6">
                <div class="stat-card bg-primary-gradient shadow-sm">
                    <h5>Total Pegawai Terdaftar</h5>
                    <div class="stat-value">{{ number_format($totalPegawai, 0, ',', '.') }}</div>
                    <p class="mb-0">Orang</p>
                    <i class="bi bi-people-fill icon"></i>
                </div>
            </div>

            {{-- Kartu Total Potongan Tahun Ini --}}
            <div class="col-md-6">
                <div class="stat-card bg-success-gradient shadow-sm">
                    <h5>Akumulasi Potongan Tahun {{ $tahunIni }}</h5>
                    <div class="stat-value">Rp {{ number_format($totalPotonganTahunIni, 0, ',', '.') }}</div>
                    <p class="mb-0">Total Dana Terkumpul</p>
                    <i class="bi bi-wallet-fill icon"></i>
                </div>
            </div>
        </div>
        {{-- AKHIR KARTU STATISTIK --}}

        <hr class="my-5">

        {{-- Tombol Aksi Cepat --}}
        <div class="text-center">
            <h3>Aksi Cepat</h3>
            <p>Kelola data pegawai dan potongan dana pensiun dengan mudah.</p>
            <a href="{{ route('pegawais.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-card-list"></i> Manajemen Data Pegawai
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>