<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .wrapper {
            width: 100%;
        }

        .title {
            text-align: center;
            margin-bottom: 6px;
            font-size: 20px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
            color: #4b5563;
        }

        .info {
            margin-bottom: 12px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Laporan Buku Perpustakaan</div>
        <div class="subtitle">Daftar data buku perpustakaan</div>

        <div class="info">
            <strong>Tanggal cetak:</strong>{{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Kategori</th>
                    <th style="width: 70px;">Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->category->name ?? '-' }}</td>
                        <td>{{ $book->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Tidak ada data buku</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Total Buku: {{ $books->count() }}
        </div>
    </div>
</body>
</html>