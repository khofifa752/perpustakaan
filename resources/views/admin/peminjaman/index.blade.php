
@extends('admin.layouts.main')

@section('page-title', 'Peminjaman')
@section('page-subtitle', 'Kelola data peminjaman aktif')

@section('main-content')
<div class="w-full">

  <div class="mb-6">
     <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Kelola Peminjaman</h1>
    </h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Kelola peminjaman yang sedang berjalan</p>
  </div>

  @if(session('success'))
    <div class="mb-4 rounded-xl bg-green-50 border border-green-100 px-4 py-3 text-sm text-green-600 font-light">
      {{ session('success') }}
    </div>
  @endif

  <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-xl">
      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
        </svg>
      </span>
      <input id="tableSearch" type="text" placeholder="Cari peminjaman"
        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-sm text-gray-700 shadow-sm focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-100">
    </div>
    <div class="flex items-center gap-4">
      <button type="button" onclick="openPeminjamanLaporanModal()"
        class="rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-gray-700 transition">
        Generate Laporan
      </button>
      <div class="text-sm text-gray-400 font-light">
        Total: <span class="font-medium text-gray-700">{{ $bookings->count() }}</span> peminjaman
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
            <th class="px-6 py-4 font-medium text-right">Aksi</th>
          </tr>
        </thead>
        <tbody id="bookingTbody" class="divide-y divide-gray-50">
          @forelse($bookings as $b)
            @php
              $badge = match($b->status) {
                'Diajukan'             => 'bg-yellow-50 text-yellow-600',
                'Disetujui','Dipinjam' => 'bg-green-50 text-green-600',
                'Menunggu Pengembalian' => 'bg-blue-50 text-blue-600',
                default                => 'bg-gray-50 text-gray-500',
              };
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
              <td class="px-6 py-4 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-2 justify-end">
                  @if($b->status === 'Diajukan')
                    <form action="{{ route('admin.peminjaman.updateStatus', $b->id) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="status" value="Disetujui">
                      <button type="submit" onclick="return confirm('Setujui peminjaman ini?')"
                        class="inline-flex items-center rounded-lg bg-green-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-green-700 transition">
                        ✓ Setujui
                      </button>
                    </form>
                    <form action="{{ route('admin.peminjaman.updateStatus', $b->id) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="status" value="Ditolak">
                      <button type="submit" onclick="return confirm('Tolak peminjaman ini?')"
                        class="inline-flex items-center rounded-lg bg-red-500 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-red-600 transition">
                        ✗ Tolak
                      </button>
                    </form>
                  @elseif($b->status === 'Ditolak')
                    <!-- <form action="{{ route('admin.peminjaman.updateStatus', $b->id) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="status" value="Diajukan">
                      <button type="submit" onclick="return confirm('Batalkan penolakan?')"
                        class="inline-flex items-center rounded-lg bg-yellow-500 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-yellow-600 transition">
                        ↩ Batalkan
                      </button>
                    </form> -->
                  @else
                    <span class="text-xs text-gray-300 italic">—</span>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400 font-light">
                Tidak ada peminjaman aktif.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- Modal Laporan --}}
<div id="peminjamanLaporanModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 p-4">
  <div class="w-full max-w-5xl rounded-2xl bg-white p-6 shadow-2xl max-h-[90vh] overflow-auto border border-gray-100">
    <div class="mb-4 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900" style="font-family:'Playfair Display',serif;">Preview Laporan Peminjaman</h2>
        <p class="text-sm text-gray-400 font-light">Tampilan laporan dokumen</p>
      </div>
      <button onclick="closePeminjamanLaporanModal()"
        class="rounded-lg bg-red-50 text-red-500 px-4 py-2 text-sm font-medium hover:bg-red-100 transition">Tutup</button>
    </div>
    <div id="peminjamanPrintArea" class="mx-auto min-h-[900px] max-w-[900px] rounded bg-white p-10 border border-gray-100">
      <div class="mb-5 text-center">
        <div class="text-2xl font-bold">Laporan Data Peminjaman</div>
        <div class="mt-1 text-sm text-gray-500">Daftar peminjaman aktif perpustakaan</div>
      </div>
      <div class="mb-4 text-sm"><strong>Tanggal Cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</div>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-gray-50">
            <th class="border border-gray-200 px-3 py-2 text-left">No</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Kode</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Judul Buku</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Peminjam</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Status</th>
            <th class="border border-gray-200 px-3 py-2 text-left">Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $index => $item)
          <tr>
            <td class="border border-gray-200 px-3 py-2">{{ $index + 1 }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->code ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->book->title ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->user->name ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ $item->status ?? '-' }}</td>
            <td class="border border-gray-200 px-3 py-2">{{ optional($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
          </tr>
          @empty
          <tr><td colspan="6" class="border border-gray-200 px-3 py-4 text-center">Tidak ada data</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4 text-sm"><strong>Total:</strong> {{ $bookings->count() }}</div>
    </div>
    <div class="mt-5 flex justify-end gap-3">
      <button onclick="printPeminjamanLaporan()"
        class="rounded-lg bg-yellow-50 text-yellow-600 px-4 py-2 text-sm font-medium hover:bg-yellow-100 transition">Print</button>
      <a href="{{ route('admin.peminjaman.laporan.download', ['q' => request('q')]) }}"
        class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Download PDF</a>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
const searchInput = document.getElementById('tableSearch');
const tbody = document.getElementById('bookingTbody');
if (searchInput && tbody) {
    const rows = Array.from(tbody.querySelectorAll('tr'));
    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        rows.forEach(row => { row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none'; });
    });
}
function openPeminjamanLaporanModal() {
    const m = document.getElementById('peminjamanLaporanModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closePeminjamanLaporanModal() {
    const m = document.getElementById('peminjamanLaporanModal');
    m.classList.add('hidden'); m.classList.remove('flex');
}
window.addEventListener('click', e => {
    const m = document.getElementById('peminjamanLaporanModal');
    if (e.target === m) closePeminjamanLaporanModal();
});
function printPeminjamanLaporan() {
    const content = document.getElementById('peminjamanPrintArea').innerHTML;
    const w = window.open('','','width=1000,height=700');
    w.document.write(`<html><head><title>Laporan</title><style>body{font-family:Arial,sans-serif;padding:24px}table{width:100%;border-collapse:collapse;font-size:14px}th,td{border:1px solid #e5e7eb;padding:8px;text-align:left}th{background:#f9fafb}</style></head><body>${content}</body></html>`);
    w.document.close(); w.focus(); w.print();
}
</script>
@endsection