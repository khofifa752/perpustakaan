@extends('admin.layouts.main')

@section('main-content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
  <div>
    <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Buku <em>Perpustakaan</em></h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Kelola data buku perpustakaan</p>
  </div>
  <div class="flex gap-2">
    <button type="button" onclick="openLaporanModal()"
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition shadow-sm">
        📄 Generate Laporan
    </button>
    <a href="{{ route('admin.books.create') }}"
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 transition shadow-sm">
        + Tambah Buku
    </a>
  </div>
</div>

{{-- MODAL LAPORAN --}}
<div id="laporanModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; justify-content:center; align-items:center; padding:24px;">
    <div style="width:100%; max-width:950px; max-height:90vh; overflow:auto; background:#f9fafb; border-radius:20px; box-shadow:0 25px 60px rgba(0,0,0,0.2); padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="margin:0; font-size:20px; font-weight:700; color:#111827;">Preview Laporan Buku</h2>
                <p style="margin:4px 0 0; color:#9ca3af; font-size:13px;">Tampilan laporan seperti file dokumen</p>
            </div>
            <button type="button" onclick="closeLaporanModal()" style="background:#f3f4f6; color:#374151; border:none; border-radius:10px; padding:8px 16px; font-weight:600; cursor:pointer; font-size:13px;">✕ Tutup</button>
        </div>

        <div id="printArea" style="background:white; width:100%; max-width:800px; margin:0 auto; min-height:1000px; padding:40px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
            <div style="text-align:center; margin-bottom:24px; border-bottom:2px solid #f3f4f6; padding-bottom:20px;">
                <div style="font-size:22px; font-weight:700; color:#111827;">Laporan Buku Perpustakaan</div>
                <div style="margin-top:6px; color:#9ca3af; font-size:13px;">Daftar data buku perpustakaan</div>
            </div>
            <div style="margin-bottom:16px; font-size:13px; color:#6b7280;">
                <strong style="color:#374151;">Tanggal Cetak:</strong> {{ now()->format('d-m-Y H:i') }}
            </div>
            <table width="100%" cellspacing="0" cellpadding="10" style="border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#f9fafb;">
                        <th style="border:1px solid #e5e7eb; color:#374151;" align="left">No</th>
                        <th style="border:1px solid #e5e7eb; color:#374151;" align="left">Judul</th>
                        <th style="border:1px solid #e5e7eb; color:#374151;" align="left">Penulis</th>
                        <th style="border:1px solid #e5e7eb; color:#374151;" align="left">Penerbit</th>
                        <th style="border:1px solid #e5e7eb; color:#374151;" align="left">Kategori</th>
                        <th style="border:1px solid #e5e7eb; color:#374151;" align="left">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                        <tr style="{{ $index % 2 == 0 ? 'background:#ffffff;' : 'background:#f9fafb;' }}">
                            <td style="border:1px solid #e5e7eb; color:#6b7280;">{{ $index + 1 }}</td>
                            <td style="border:1px solid #e5e7eb; font-weight:600; color:#111827;">{{ $book->title }}</td>
                            <td style="border:1px solid #e5e7eb; color:#374151;">{{ $book->author }}</td>
                            <td style="border:1px solid #e5e7eb; color:#374151;">{{ $book->publisher }}</td>
                            <td style="border:1px solid #e5e7eb; color:#374151;">{{ $book->categories->pluck('name')->join(', ') ?: '-' }}</td>
                            <td style="border:1px solid #e5e7eb; color:#374151;">{{ $book->stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="border:1px solid #e5e7eb; text-align:center; color:#9ca3af; padding:20px;">Tidak ada data buku</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top:16px; font-size:13px; color:#6b7280;">
                <strong style="color:#374151;">Total Buku:</strong> {{ $books->count() }}
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:18px;">
            <button type="button" onclick="printLaporan()" style="background:#f3f4f6; color:#374151; border:none; border-radius:10px; padding:10px 18px; font-weight:600; cursor:pointer; font-size:13px;">🖨️ Print</button>
            <a href="{{ route('admin.books.laporan.pdf', ['q' => request('q')]) }}" style="background:#111827; color:white; text-decoration:none; border-radius:10px; padding:10px 18px; font-weight:600; display:inline-block; font-size:13px;">⬇️ Download PDF</a>
        </div>
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
  <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
    ✅ {{ session('success') }}
  </div>
@endif

{{-- SEARCH & TOTAL --}}
<div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
  <div class="relative w-full sm:max-w-md">
    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">🔎</span>
    <input id="tableSearch" type="text" placeholder="Cari judul / penulis / penerbit / kategori..."
      class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"/>
  </div>
  <div class="text-sm text-gray-400">Total: <span class="font-semibold text-gray-800">{{ $books->count() }}</span> buku</div>
</div>

{{-- TABLE --}}
<div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b border-gray-100">
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Judul</th>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Penulis</th>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Penerbit</th>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Kategori</th>
          <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-widest">Stok</th>
          <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-widest">Aksi</th>
        </tr>
      </thead>
      <tbody id="booksTbody" class="divide-y divide-gray-50">
        @forelse($books as $book)
        <tr class="hover:bg-gray-50/60 transition">
          <td class="px-6 py-4 font-semibold text-gray-800">{{ $book->title }}</td>
          <td class="px-6 py-4 text-gray-500 font-light">{{ $book->author }}</td>
          <td class="px-6 py-4 text-gray-500 font-light">{{ $book->publisher }}</td>
          <td class="px-6 py-4">
            @foreach($book->categories as $cat)
              <span class="inline-block px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 mr-1">{{ $cat->name }}</span>
            @endforeach
          </td>
          <td class="px-6 py-4 text-center">
            @if($book->stock > 5)
              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-600">{{ $book->stock }}</span>
            @elseif($book->stock > 0)
              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-50 text-yellow-600">{{ $book->stock }}</span>
            @else
              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-50 text-red-500">Habis</span>
            @endif
          </td>
          <td class="px-6 py-4">
            <div class="flex justify-center gap-2">
              <a href="{{ route('admin.books.edit', $book) }}"
                 class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                Edit
              </a>
              <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin mau hapus buku ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                  Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-6 py-10 text-center text-gray-400 font-light">Belum ada data buku</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection

@section('script')
<script>
const searchInput = document.getElementById('tableSearch');
const tbody = document.getElementById('booksTbody');

if (searchInput && tbody) {
    const rows = Array.from(tbody.querySelectorAll('tr'));
    searchInput.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
        });
    });
}

function openLaporanModal() {
    document.getElementById('laporanModal').style.display = 'flex';
}

function closeLaporanModal() {
    document.getElementById('laporanModal').style.display = 'none';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('laporanModal');
    if (e.target === modal) closeLaporanModal();
});

function printLaporan() {
    const content = document.getElementById('printArea').innerHTML;
    const printWindow = window.open('', '', 'width=900,height=700');
    printWindow.document.write(`
        <html><head><title>Print Laporan Buku</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 24px; color: #111827; }
            table { width: 100%; border-collapse: collapse; font-size: 13px; }
            th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
            th { background: #f9fafb; }
        </style></head>
        <body>${content}</body></html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>
@endsection