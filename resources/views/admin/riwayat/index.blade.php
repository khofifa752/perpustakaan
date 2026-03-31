@extends('admin.layouts.main')

@section('page-title', 'Riwayat Peminjaman')
@section('page-subtitle', 'Daftar peminjaman selesai & ditolak')

@section('main-content')
<div class="w-full">

  <div class="mb-6">
     <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Riwayat Peminjaman </em></h1>
    </h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Peminjaman yang telah selesai atau ditolak</p>
  </div>

  @if(session('success'))
    <div class="mb-4 rounded-xl bg-green-50 border border-green-100 px-4 py-3 text-sm text-green-600 font-light">
      {{ session('success') }}
    </div>
  @endif

  <!-- Filter status pills -->
  <div class="flex items-center gap-2 mb-5 flex-wrap">
    <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
       class="px-4 py-1.5 rounded-full text-xs font-medium border transition
       {{ !request('status') ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400' }}">
      Semua
    </a>
    <a href="{{ request()->fullUrlWithQuery(['status' => 'Dikembalikan']) }}"
       class="px-4 py-1.5 rounded-full text-xs font-medium border transition
       {{ request('status') === 'Dikembalikan' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400' }}">
      Dikembalikan
    </a>
    <a href="{{ request()->fullUrlWithQuery(['status' => 'Ditolak']) }}"
       class="px-4 py-1.5 rounded-full text-xs font-medium border transition
       {{ request('status') === 'Ditolak' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400' }}">
      Ditolak
    </a>
  </div>

  <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-xl">
      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
        </svg>
      </span>
      <form method="GET">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input name="q" type="text" value="{{ request('q') }}"
          placeholder="Cari kode, peminjam, atau judul buku..."
          class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-sm text-gray-700 shadow-sm focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-100">
      </form>
    </div>
    <div class="flex items-center gap-3">
      <button type="button" onclick="openRiwayatModal()"
        class="rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-gray-700 transition">
        Generate Laporan
      </button>
      <div class="text-sm text-gray-400 font-light">
        Total: <span class="font-medium text-gray-700">{{ $bookings->total() }}</span> riwayat
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-left text-sm text-gray-700">
        <thead class="bg-gray-50 text-xs uppercase text-gray-400 tracking-wider">
          <tr>
            <th class="px-6 py-4 font-medium">Kode</th>
            <th class="px-6 py-4 font-medium">Judul Buku</th>
            <th class="px-6 py-4 font-medium">Peminjam</th>
            <th class="px-6 py-4 font-medium">Status</th>
            <th class="px-6 py-4 font-medium">Tanggal Pinjam</th>
            <th class="px-6 py-4 font-medium">Tenggat Kembali</th>
            <th class="px-6 py-4 font-medium">Tanggal Selesai</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($bookings as $b)
            @php
              $badge = $b->status === 'Dikembalikan'
                ? 'bg-green-50 text-green-600'
                : 'bg-red-50 text-red-500';

              $selesai = $b->status === 'Dikembalikan'
                ? ($b->returned_at ? $b->returned_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') : '-')
                : ($b->updated_at  ? $b->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')  : '-');

              $tenggatLabel = $b->expired_at
                ? $b->expired_at->format('d-m-Y')
                : '-';

              $tenggatColor = '';
              if ($b->expired_at && $b->status === 'Dikembalikan' && $b->returned_at) {
                $tenggatColor = $b->returned_at->gt($b->expired_at)
                  ? 'text-red-500' : 'text-gray-500';
              }
            @endphp
            <tr class="hover:bg-gray-50/60 transition">
              <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $b->code ?? '-' }}</td>
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ $b->book->title ?? '-' }}</div>
                <div class="text-xs text-gray-400 font-light">{{ $b->book->author ?? '' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $b->user->name ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $badge }}">
                  {{ $b->status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-light">
                {{ optional($b->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-light {{ $tenggatColor ?: 'text-gray-500' }}">
                {{ $tenggatLabel }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-light">
                {{ $selesai }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-400 font-light">
                Belum ada riwayat peminjaman.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($bookings->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
      {{ $bookings->links() }}
    </div>
    @endif
  </div>

</div>

{{-- ── MODAL LAPORAN ── --}}
<div id="riwayatModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 p-4">
  <div class="w-full max-w-5xl rounded-2xl bg-white p-6 shadow-2xl max-h-[90vh] overflow-auto border border-gray-100">

    <div class="mb-4 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900" style="font-family:'Playfair Display',serif;">
          Preview Laporan Riwayat
        </h2>
        <p class="text-sm text-gray-400 font-light">Peminjaman selesai & ditolak</p>
      </div>
      <button onclick="closeRiwayatModal()"
        class="rounded-lg bg-red-50 text-red-500 px-4 py-2 text-sm font-medium hover:bg-red-100 transition">
        Tutup
      </button>
    </div>

    <!-- Print area -->
    <div id="riwayatPrintArea" class="mx-auto max-w-[900px] rounded bg-white p-10 border border-gray-100">
      <div class="mb-5 text-center">
        <div class="text-2xl font-bold">Laporan Riwayat Peminjaman</div>
        <div class="mt-1 text-sm text-gray-500">Perpustakaan Digital — PerpusKita</div>
      </div>
      <div class="mb-4 text-sm flex justify-between">
        <span><strong>Tanggal Cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</span>
        <span><strong>Filter:</strong> {{ request('status') ?: 'Semua' }}</span>
      </div>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-gray-50">
            <th class="border border-gray-200 px-3 py-2 text-left">No</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Kode</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Judul Buku</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Peminjam</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Status</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Tgl Pinjam</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Tenggat</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Tgl Selesai</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $i => $item)
          @php
            $itemSelesai = $item->status === 'Dikembalikan'
              ? ($item->returned_at ? $item->returned_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') : '-')
              : ($item->updated_at  ? $item->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')  : '-');
          @endphp
          <tr>
            <td class="border border-gray-200 px-3 py-2">{{ ($bookings->currentPage()-1) * $bookings->perPage() + $i + 1 }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->code ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->book->title ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->user->name ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->status ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ optional($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->expired_at ? $item->expired_at->format('d-m-Y') : '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $itemSelesai }}</td>
          </tr>
          @empty
          <tr><td colspan="8" class="border border-gray-200 px-3 py-4 text-center">Tidak ada data</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4 text-sm"><strong>Total:</strong> {{ $bookings->total() }} riwayat</div>
    </div>

    <div class="mt-5 flex justify-end gap-3">
      <button onclick="printRiwayat()"
        class="rounded-lg bg-yellow-50 text-yellow-600 px-4 py-2 text-sm font-medium hover:bg-yellow-100 transition">
        <i class="fas fa-print mr-1"></i> Print
      </button>
      <a href="{{ route('admin.riwayat.laporan.download', ['q' => request('q'), 'status' => request('status')]) }}"
        class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
        <i class="fas fa-download mr-1"></i> Download PDF
      </a>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
function openRiwayatModal() {
    const m = document.getElementById('riwayatModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closeRiwayatModal() {
    const m = document.getElementById('riwayatModal');
    m.classList.add('hidden'); m.classList.remove('flex');
}
window.addEventListener('click', e => {
    const m = document.getElementById('riwayatModal');
    if (e.target === m) closeRiwayatModal();
});
function printRiwayat() {
    const content = document.getElementById('riwayatPrintArea').innerHTML;
    const w = window.open('', '', 'width=1100,height=750');
    w.document.write(`
        <html><head><title>Laporan Riwayat Peminjaman</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 24px; color: #111; }
            table { width: 100%; border-collapse: collapse; font-size: 12px; }
            th, td { border: 1px solid #e5e7eb; padding: 7px 10px; text-align: left; }
            th { background: #f9fafb; font-weight: 600; }
        </style></head>
        <body>${content}</body></html>
    `);
    w.document.close(); w.focus(); w.print();
}
</script>
@endsection