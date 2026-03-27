<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Petugas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 24px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 18px;
        }

        .date {
            margin-bottom: 14px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 7px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 14px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="title">Laporan Data Petugas</div>
    <div class="subtitle">Daftar akun petugas perpustakaan</div>

    <div class="date">
        <strong>Tanggal cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width: 100px;">Role</th>
                <th style="width: 170px;">Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="text-center">{{ $item->role }}</td>
                    <td class="text-center">
                        {{ $item->created_at ? $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data petugas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>Total Petugas:</strong> {{ $petugas->count() }}
    </div>
</body>
</html>