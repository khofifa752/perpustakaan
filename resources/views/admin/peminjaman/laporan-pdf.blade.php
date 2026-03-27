<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
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
    <div class="title">Laporan Data Peminjaman</div>
    <div class="subtitle">Daftar data peminjaman buku perpustakaan</div>

    <div class="date">
        <strong>Tanggal cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35px;">No</th>
                <th>Kode</th>
                <th>Judul Buku</th>
                <th>Peminjam</th>
                <th>Status</th>
                <th style="width: 135px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $booking->code }}</td>
                    <td>{{ $booking->book->title ?? '-' }}</td>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td class="text-center">{{ $booking->status }}</td>
                    <td class="text-center">
                        {{ optional($booking->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>Total Peminjaman:</strong> {{ $bookings->count() }}
    </div>
</body>
</html>