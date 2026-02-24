<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan</title>
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #000;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>LAPORAN DATA PENGADUAN</h2>
    <div class="sub">
        Sistem Pengaduan Siswa<br>
        Tanggal Cetak: {{ date('d-m-Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($complaints as $key => $c)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $c->created_at->format('d-m-Y') }}</td>
                    <td>{{ $c->user->name }}</td>
                    <td>{{ $c->category->nama_kategori }}</td>
                    <td>{{ $c->title }}</td>
                    <td class="text-center">{{ ucfirst($c->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Mengetahui,<br><br><br><br>
        _______________________<br>
        Admin
    </div>

</body>
</html>