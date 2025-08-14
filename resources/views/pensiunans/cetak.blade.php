<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan pegawai Pendeta GPI Papua</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
        }
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 4px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat .logo {
            width: 90px;
            height: auto;
        }
        .kop-surat .teks-kop {
            text-align: center;
            flex-grow: 1;
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

        @page {
            size: A4 landscape; /* Mengatur halaman menjadi landscape */
            margin: 20mm;
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
        <img src="{{ asset('images/logo.png') }}" alt="Logo GPI Papua" class="logo">
        <div class="teks-kop">
            <h4>MAJELIS PEKERJA SINODE</h4>
            <h5>GEREJA PROTESTAN INDONESIA (GPI) DI PAPUA</h5>
            <p>Alamat: Jln. Imam bonjol No.1, Fakfak, KOTAK POS 98611</p>
            <p>Telp. (0967) 531495, Fax. (0956) 531495</p>
        </div>
    </div>

    <div class="judul-laporan">
        <h5>REKAPAN DATA POTONGAN pegawai PENDETA</h5>
        <p>Periode Tahun {{ \Carbon\Carbon::now()->year }}</p>
    </div>

    @if ($search)
        <p>Hasil pencarian untuk: <strong>"{{ $search }}"</strong></p>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Lengkap</th>
                <th rowspan="2">Status</th>
                <th colspan="12">Rincian Potongan Bulanan (Rp)</th>
                <th rowspan="2">Total (Rp)</th>
            </tr>
            <tr>
                <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>Mei</th><th>Jun</th>
                <th>Jul</th><th>Ags</th><th>Sep</th><th>Okt</th><th>Nov</th><th>Des</th>
            </tr>
        </thead>
        <tbody>
            @php $grand_total = 0; @endphp
            @forelse ($pegawais as $pegawai)
                @php
                    $total_potongan_per_orang = 
                        $pegawai->potongan_januari + $pegawai->potongan_februari + $pegawai->potongan_maret + 
                        $pegawai->potongan_april + $pegawai->potongan_mei + $pegawai->potongan_juni +
                        $pegawai->potongan_juli + $pegawai->potongan_agustus + $pegawai->potongan_september +
                        $pegawai->potongan_oktober + $pegawai->potongan_november + $pegawai->potongan_desember;
                    $grand_total += $total_potongan_per_orang;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-start">{{ $pegawai->nama_pegawai }}</td>
                    <td class="text-center">{{ $pegawai->status }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_januari, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_februari, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_maret, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_april, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_mei, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_juni, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_juli, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_agustus, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_september, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_oktober, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_november, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($pegawai->potongan_desember, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">{{ number_format($total_potongan_per_orang, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" class="text-center">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="15" class="text-end fw-bold">TOTAL KESELURUHAN</td>
                <td class="text-end fw-bold">{{ number_format($grand_total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>