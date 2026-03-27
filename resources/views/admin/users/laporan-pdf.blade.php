<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan User</title>
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
    <div class="title">Laporan Data User</div>
    <div class="subtitle">Daftar pengguna perpustakaan</div>

    <div class="date">
        <strong>Tanggal cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width: 100px;">Total Pinjam</th>
                <th style="width: 90px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">{{ $user->bookings_count ?? 0 }}</td>
                    <td class="text-center">
                        {{ $user->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data user</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>Total User:</strong> {{ $users->count() }}
    </div>
</body>
</html>