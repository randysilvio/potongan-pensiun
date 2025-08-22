<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Potongan Dana Pensiun Pegawai</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 10pt; color: #000; }
        .kop-surat { text-align: center; border-bottom: 4px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat img { width: 70px; margin-bottom: 10px; }
        .kop-surat h4, .kop-surat h5 { margin: 0; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 9pt; }
        .judul-laporan { text-align: center; margin-bottom: 20px; }
        .judul-laporan h5 { text-decoration: underline; font-weight: bold; margin: 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        .table thead th { text-align: center; background-color: #e9ecef; font-weight: bold; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-start { text-align: left; }
        .fw-bold { font-weight: bold; }
        .signature-container { margin-top: 40px; page-break-inside: avoid; }
        .signature-block { text-align: center; width: 280px; float: right; }
        .signature-line { border-bottom: 1px solid #000; margin-top: 60px; font-weight: bold; }
        @page { size: A4 landscape; margin: 20mm; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo GPI Papua">
        <h4>MAJELIS PEKERJA SINODE</h4>
        <h5>GEREJA PROTESTAN INDONESIA (GPI) DI PAPUA</h5>
        <p>Alamat: Jln. Imam Bonjol, Wagom, Fakfak, Papua Barat | Telp. (0967) 531495, Fax. (0967) 531495</p>
    </div>

    <div class="judul-laporan">
        <h5>REKAPAN DATA POTONGAN DANA PENSIUN PEGAWAI</h5>
        <p>Periode Tahun {{ $tahun_mulai }} s/d {{ $tahun_akhir }}</p>
    </div>

    <table class="table">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Status</th>
                <th>Total Potongan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grand_total = 0; @endphp
            @forelse ($pegawais as $pegawai)
                @php
                    $total_potongan_per_orang = $pegawai->potonganTahunan->reduce(function ($carry, $item) {
                        $bulan_kolom = ['potongan_januari', 'potongan_februari', 'potongan_maret', 'potongan_april', 'potongan_mei', 'potongan_juni', 'potongan_juli', 'potongan_agustus', 'potongan_september', 'potongan_oktober', 'potongan_november', 'potongan_desember'];
                        $total_per_tahun = 0;
                        foreach ($bulan_kolom as $kolom) {
                            $total_per_tahun += $item->$kolom ?? 0;
                        }
                        return $carry + $total_per_tahun;
                    }, 0);
                    $grand_total += $total_potongan_per_orang;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-start">{{ $pegawai->nama_pegawai }}</td>
                    <td class="text-center">{{ $pegawai->status }}</td>
                    <td class="text-end fw-bold">{{ number_format($total_potongan_per_orang, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data tidak ditemukan untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">TOTAL KESELURUHAN</td>
                <td class="text-end fw-bold">{{ number_format($grand_total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="signature-container">
        <div class="signature-block">
            <p>{{ $settings['tempat'] }}, {{ \Carbon\Carbon::parse($settings['tanggal'])->translatedFormat('d F Y') }}</p>
            <p>Yang Bertanda Tangan,</p>
            <div style="height: 60px;"></div>
            <div class="signature-line">
                {{ $settings['petugas'] }}
            </div>
            <p>{{ $settings['jabatan'] }}</p>
        </div>
    </div>
</body>
</html>