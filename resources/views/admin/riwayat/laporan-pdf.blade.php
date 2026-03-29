<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Riwayat Peminjaman</title>
<style>
  body { font-family: Arial, sans-serif; font-size: 12px; color: #111; padding: 20px; }
  h1 { font-size: 18px; text-align: center; margin-bottom: 4px; }
  .sub { text-align: center; font-size: 11px; color: #666; margin-bottom: 16px; }
  .meta { font-size: 11px; margin-bottom: 12px; display: flex; justify-content: space-between; }
  table { width: 100%; border-collapse: collapse; font-size: 11px; }
  th { background: #f3f4f6; font-weight: 600; text-align: left; padding: 7px 10px; border: 1px solid #e5e7eb; }
  td { padding: 6px 10px; border: 1px solid #e5e7eb; vertical-align: top; }
  tr:nth-child(even) td { background: #fafafa; }
  .badge-green { background: #dcfce7; color: #16a34a; padding: 2px 8px; border-radius: 20px; }
  .badge-red   { background: #fee2e2; color: #dc2626; padding: 2px 8px; border-radius: 20px; }
  .footer { margin-top: 16px; font-size: 11px; color: #666; }
</style>
</head>
<body>

<h1>Laporan Riwayat Peminjaman</h1>
<div class="sub">Perpustakaan Digital — PerpusKita</div>

<div class="meta">
  <span><strong>Tanggal Cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</span>
  <span><strong>Filter:</strong> {{ $status ?: 'Semua' }}</span>
</div>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Kode</th>
      <th>Judul Buku</th>
      <th>Peminjam</th>
      <th>Status</th>
      <th>Tgl Pinjam</th>
      <th>Tenggat Kembali</th>
      <th>Tgl Selesai</th>
    </tr>
  </thead>
  <tbody>
    @forelse($bookings as $i => $item)
    @php
      $selesai = $item->status === 'Dikembalikan'
        ? ($item->returned_at ? $item->returned_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') : '-')
        : ($item->updated_at  ? $item->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')  : '-');
    @endphp
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $item->code ?? '-' }}</td>
      <td>{{ $item->book->title ?? '-' }}</td>
      <td>{{ $item->user->name ?? '-' }}</td>
      <td>
        <span class="{{ $item->status === 'Dikembalikan' ? 'badge-green' : 'badge-red' }}">
          {{ $item->status }}
        </span>
      </td>
      <td>{{ optional($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
      <td>{{ $item->expired_at ? $item->expired_at->format('d-m-Y') : '-' }}</td>
      <td>{{ $selesai }}</td>
    </tr>
    @empty
    <tr><td colspan="8" style="text-align:center;padding:16px;">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer"><strong>Total:</strong> {{ $bookings->count() }} riwayat</div>

</body>
</html>