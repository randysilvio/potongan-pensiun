<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekap Personal Pegawai: {{ $pegawai->nama_pegawai }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
        }
        .kop-surat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-bottom: 4px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat .logo {
            width: 70px;
            height: auto;
            margin-bottom: 5px;
        }
        .kop-surat .teks-kop {
            text-align: center;
            line-height: 1.2;
        }
        .kop-surat h4, .kop-surat h5 {
            margin: 0;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 0;
            font-size: 10pt;
        }
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h5 {
            text-decoration: underline;
            font-weight: bold;
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000 !important;
            padding: 4px 6px;
            vertical-align: middle;
        }
        .table thead th {
            text-align: center;
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-start { text-align: left; }
        .fw-bold { font-weight: bold; }
        .signature-container {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-block {
            text-align: center;
            width: 300px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 60px;
            font-weight: bold;
            padding: 0 10px;
        }
        @page {
            size: A4 landscape;
            margin: 20mm;
            counter-increment: page;
            @bottom-right {
                content: "Halaman " counter(page) " dari " counter(pages);
            }
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
</head>
<body onload="window.print()">
    
    <div class="kop-surat">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo GPI Papua" class="logo">
        <div class="teks-kop">
            <h4>MAJELIS PEKERJA SINODE</h4>
            <h5>GEREJA PROTESTAN INDONESIA (GPI) DI PAPUA</h5>
            <p>Alamat: Jln. Imam Bonjol, Wagom, Fakfak, Papua Barat </p>
            <p>Telp. (0967) 531495, Fax. (0967) 531495</p>
        </div>
    </div>

    <div class="judul-laporan">
        <h5>REKAP DATA POTONGAN DANA PENSIUN PEGAWAI</h5>
        <p>Nama Pegawai: {{ $pegawai->nama_pegawai }}</p>
        <p>Periode Tahun: {{ $tahun }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" class="text-center">No</th>
                <th rowspan="2" class="text-center">Nama Pegawai</th>
                <th colspan="12" class="text-center">Rincian Potongan Bulanan (Rp)</th>
                <th rowspan="2" class="text-center">Total (Rp)</th>
            </tr>
            <tr>
                <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>Mei</th><th>Jun</th>
                <th>Jul</th><th>Ags</th><th>Sep</th><th>Okt</th><th>Nov</th><th>Des</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_potongan = 0;
                $bulan_kolom = ['potongan_januari', 'potongan_februari', 'potongan_maret', 'potongan_april', 'potongan_mei', 'potongan_juni', 'potongan_juli', 'potongan_agustus', 'potongan_september', 'potongan_oktober', 'potongan_november', 'potongan_desember'];

                if ($potongan_data) {
                    foreach ($bulan_kolom as $kolom) {
                        $total_potongan += $potongan_data->$kolom;
                    }
                }
            @endphp
            <tr>
                <td class="text-center">1</td>
                <td>{{ $pegawai->nama_pegawai }}</td>
                @if($potongan_data)
                    @foreach($bulan_kolom as $kolom)
                        <td class="text-end">{{ number_format($potongan_data->$kolom, 0, ',', '.') }}</td>
                    @endforeach
                @else
                    <td class="text-center" colspan="12">Tidak ada data potongan untuk tahun ini.</td>
                @endif
                <td class="text-end fw-bold">{{ number_format($total_potongan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="15" class="text-end fw-bold">TOTAL KESELURUHAN</td>
                <td class="text-end fw-bold">{{ number_format($total_potongan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="signature-container">
        <div class="signature-block">
            <p>Jayapura, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Yang Bertanda Tangan,</p>
            <div class="signature-line">
                <p>NAMA PETUGAS</p>
            </div>
            <p>Jabatan</p>
        </div>
    </div>
</body>
</html>