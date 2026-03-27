@extends('admin.layouts.main')

@section('main-content')
<div class="w-full">

  <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">Peminjaman</h1>
    <p class="text-sm text-gray-500">Kelola data peminjaman buku</p>
  </div>

  @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
      {{ session('success') }}
    </div>
  @endif

  <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-xl">
      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
        </svg>
      </span>
      <input
        id="tableSearch"
        type="text"
        placeholder="Cari peminjaman"
        class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
      >
    </div>

    <div class="flex items-center gap-4">
      <button
        type="button"
        onclick="openPeminjamanLaporanModal()"
        class="rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-green-700 transition"
      >
        Generate Laporan
      </button>
      <div class="text-sm text-gray-500">
        Total: <span class="font-medium text-gray-700">{{ $bookings->count() }}</span> peminjaman
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
      <table class="min-w-full text-left text-sm text-gray-700">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
          <tr>
            <th class="px-6 py-4">Kode</th>
            <th class="px-6 py-4">Judul Buku</th>
            <th class="px-6 py-4">Peminjam</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>

        <tbody id="bookingTbody" class="divide-y divide-gray-100">
          @forelse($bookings as $b)
            @php
              $st = strtolower($b->status ?? '');
              $badge = 'bg-yellow-100 text-yellow-700';
              if ($st === 'disetujui' || $st === 'dikembalikan') $badge = 'bg-green-100 text-green-700';
              if ($st === 'ditolak') $badge = 'bg-red-100 text-red-700';
              if ($st === 'dipinjam') $badge = 'bg-blue-100 text-blue-700';
            @endphp

            <tr class="hover:bg-gray-50/60">
              <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                {{ $b->code ?? '-' }}
              </td>

              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ $b->book->title ?? '-' }}</div>
                <div class="text-xs text-gray-400">{{ $b->book->author ?? '' }}</div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                {{ $b->user->name ?? '-' }}
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $badge }}">
                  {{ $b->status ?? '-' }}
                </span>
              </td>

              <td class="px-6 py-4 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-2 justify-end">

                  {{-- Tombol Setujui — hanya muncul kalau status Diajukan --}}
                  @if($b->status === 'Diajukan')
                    <form action="{{ route('admin.peminjaman.updateStatus', $b->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="Disetujui">
                      <button type="submit"
                        class="inline-flex items-center rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-green-700 transition"
                        onclick="return confirm('Setujui peminjaman ini?')"
                      >
                        ✓ Setujui
                      </button>
                    </form>

                    <form action="{{ route('admin.peminjaman.updateStatus', $b->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="Ditolak">
                      <button type="submit"
                        class="inline-flex items-center rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-600 transition"
                        onclick="return confirm('Tolak peminjaman ini?')"
                      >
                        ✗ Tolak
                      </button>
                    </form>

                  {{-- Tombol Kembalikan — hanya muncul kalau status Disetujui / Dipinjam --}}
                  @elseif($b->status === 'Disetujui' || $b->status === 'Dipinjam')
                    <form action="{{ route('admin.peminjaman.updateStatus', $b->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="Dikembalikan">
                      <button type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 transition"
                        onclick="return confirm('Tandai buku ini sudah dikembalikan?')"
                      >
                        ↩ Kembalikan
                      </button>
                    </form>

                  {{-- Status sudah final --}}
                  @else
                    <span class="text-xs text-gray-400 italic">—</span>
                  @endif

                  {{-- Detail tetap ada --}}
                  <a
                    href="{{ route('admin.peminjaman.show', $b->id) }}"
                    class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm hover:bg-gray-50 transition"
                  >
                    Detail
                  </a>

                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                Belum ada data peminjaman.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- Modal Laporan --}}
<div
  id="peminjamanLaporanModal"
  class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4"
>
  <div class="w-full max-w-5xl rounded-2xl bg-[#f3f4f6] p-5 shadow-2xl max-h-[90vh] overflow-auto">
    <div class="mb-4 flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Preview Laporan Peminjaman</h2>
        <p class="text-sm text-gray-500">Tampilan laporan seperti file dokumen</p>
      </div>
      <button
        type="button"
        onclick="closePeminjamanLaporanModal()"
        class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600"
      >
        Tutup
      </button>
    </div>

    <div id="peminjamanPrintArea" class="mx-auto min-h-[900px] max-w-[900px] rounded bg-white p-10 shadow">
      <div class="mb-5 text-center">
        <div class="text-2xl font-bold">Laporan Data Peminjaman</div>
        <div class="mt-1 text-sm text-gray-500">Daftar data peminjaman buku perpustakaan</div>
      </div>
      <div class="mb-4 text-sm">
        <strong>Tanggal Cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
      </div>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 px-3 py-2 text-left">No</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Kode</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Judul Buku</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Peminjam</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Status</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $index => $item)
            <tr>
              <td class="border border-gray-300 px-3 py-2">{{ $index + 1 }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->code ?? '-' }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->book->title ?? '-' }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->user->name ?? '-' }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->status ?? '-' }}</td>
              <td class="border border-gray-300 px-3 py-2">
                {{ optional($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="border border-gray-300 px-3 py-4 text-center">Tidak ada data</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4 text-sm">
        <strong>Total Peminjaman:</strong> {{ $bookings->count() }}
      </div>
    </div>

    <div class="mt-5 flex justify-end gap-3">
      <button
        type="button"
        onclick="printPeminjamanLaporan()"
        class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600"
      >
        Print
      </button>
      <a
        href="{{ route('admin.peminjaman.laporan.download', ['q' => request('q')]) }}"
        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
      >
        Download PDF
      </a>
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
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
}
function openPeminjamanLaporanModal() {
    const modal = document.getElementById('peminjamanLaporanModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closePeminjamanLaporanModal() {
    const modal = document.getElementById('peminjamanLaporanModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
window.addEventListener('click', function (e) {
    const modal = document.getElementById('peminjamanLaporanModal');
    if (e.target === modal) closePeminjamanLaporanModal();
});
function printPeminjamanLaporan() {
    const content = document.getElementById('peminjamanPrintArea').innerHTML;
    const printWindow = window.open('', '', 'width=1000,height=700');
    printWindow.document.write(`
        <html><head><title>Print Laporan Peminjaman</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 24px; color: #111827; }
            table { width: 100%; border-collapse: collapse; font-size: 14px; }
            th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
            th { background: #f3f4f6; }
        </style></head>
        <body>${content}</body></html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>
@endsection