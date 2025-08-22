{{-- resources/views/pegawai/rekap_pdf.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    {{-- Style CSS khusus untuk PDF --}}
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>REKAPITULASI DATA PERSONEL PEGAWAI</h1>
        <p>GPI PAPUA</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Tanggal Lahir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data pegawai yang dikirim dari controller --}}
            @forelse ($pegawai as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d F Y') }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data pegawai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ $date }}</p>
    </div>

</body>
</html>