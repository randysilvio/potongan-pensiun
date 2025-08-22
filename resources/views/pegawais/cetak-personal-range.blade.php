<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1">
    <title>Laporan Personal {{ $pegawai->nama_pegawai }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; color: #000; }
        .kop-surat { text-align: center; border-bottom: 4px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat img { width: 70px; margin-bottom: 10px; }
        .kop-surat h4, .kop-surat h5 { margin: 0; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 10pt; }
        .judul-laporan { text-align: center; margin-bottom: 15px; }
        .judul-laporan h5 { text-decoration: underline; font-weight: bold; margin: 0; }
        .bio-data { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 9pt; }
        .table th, .table td { border: 1px solid #000; padding: 5px; vertical-align: middle; }
        .table thead th { text-align: center; background-color: #e9ecef; font-weight: bold; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .signature-container { margin-top: 30px; page-break-inside: avoid; }
        .signature-block { text-align: center; width: 300px; float: right; }
        .signature-line { margin-top: 60px; font-weight: bold; border-bottom: 1px solid #000; }
        /* Mengubah ukuran margin untuk mode landscape */
        @page { size: A4 landscape; margin: 20mm; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo GPI Papua">
        <h4>MAJELIS PEKERJA SINODE</h4>
        <h5>GEREJA PROTESTAN INDONESIA (GPI) DI PAPUA</h5>
        <p>Alamat: Jln. Imam Bonjol, Wagom, Fakfak, Papua Barat</p>
    </div>

    <div class="judul-laporan">
        <h5>REKAPITULASI DATA POTONGAN DANA PENSIUN</h5>
    </div>

    <div class="bio-data">
        <table style="border: none; width: auto;">
            <tr>
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Nama Pegawai</strong></td>
                <td style="border: none; padding: 2px;">: {{ $pegawai->nama_pegawai }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Status</strong></td>
                <td style="border: none; padding: 2px;">: {{ $pegawai->status }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Periode Laporan</strong></td>
                <td style="border: none; padding: 2px;">: {{ $tahun_mulai }} s/d {{ $tahun_akhir }}</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 5%;">Tahun</th>
                <th colspan="12">Rincian Potongan Bulanan (Rp)</th>
                <th rowspan="2" style="width: 12%;">Total (Rp)</th>
            </tr>
            <tr>
                <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>Mei</th><th>Jun</th>
                <th>Jul</th><th>Ags</th><th>Sep</th><th>Okt</th><th>Nov</th><th>Des</th>
            </tr>
        </thead>
        <tbody>
            @php $grand_total = 0; @endphp
            @forelse ($pegawai->potonganTahunan as $potongan)
                @php
                    $total_per_tahun = 0;
                    $bulan_kolom = ['potongan_januari', 'potongan_februari', 'potongan_maret', 'potongan_april', 'potongan_mei', 'potongan_juni', 'potongan_juli', 'potongan_agustus', 'potongan_september', 'potongan_oktober', 'potongan_november', 'potongan_desember'];
                    foreach ($bulan_kolom as $kolom) {
                        $total_per_tahun += $potongan->$kolom ?? 0;
                    }
                    $grand_total += $total_per_tahun;
                @endphp
                <tr>
                    <td class="text-center fw-bold">{{ $potongan->tahun }}</td>
                    @foreach($bulan_kolom as $kolom)
                        <td class="text-end">{{ number_format($potongan->$kolom ?? 0, 0, ',', '.') }}</td>
                    @endforeach
                    <td class="text-end fw-bold">{{ number_format($total_per_tahun, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center">Tidak ada data potongan untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="13" class="text-end fw-bold">TOTAL KESELURUHAN</td>
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
                <p style="margin: 0; padding: 0;">{{ $settings['petugas'] }}</p>
            </div>
            <p>{{ $settings['jabatan'] }}</p>
        </div>
    </div>
</body>
</html>