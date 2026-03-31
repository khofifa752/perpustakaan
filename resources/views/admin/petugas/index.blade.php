@extends('admin.layouts.main')

@section('main-content')
<div class="w-full">

  {{-- HEADER --}}
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Kelola Petugas</h1>
      <p class="text-sm text-gray-400 mt-1 font-light">Tambah, edit, dan hapus akun petugas</p>
    </div>
    <div class="flex items-center gap-2">
      <button type="button" onclick="openPetugasLaporanModal()"
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition shadow-sm">
        📄 Generate Laporan
      </button>
      <a href="{{ route('admin.petugas.create') }}"
         class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 transition shadow-sm">
        + Tambah Petugas
      </a>
    </div>
  </div>

  {{-- ALERT --}}
  @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
      ✅ {{ session('success') }}
    </div>
  @endif

  {{-- SEARCH --}}
  <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" action="{{ route('admin.petugas.index') }}" class="flex gap-2 w-full sm:max-w-xl">
      <div class="relative flex-1">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
          </svg>
        </span>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..."
          class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-sm focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-100">
      </div>
      <button type="submit" class="px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-700 transition">Cari</button>
      <a href="{{ route('admin.petugas.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Reset</a>
    </form>
  </div>

  {{-- TABLE --}}
  <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="border-b border-gray-100">
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Nama</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Email</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Role</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Dibuat</th>
            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-widest">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($petugas as $p)
            <tr class="hover:bg-gray-50/60 transition">
              <td class="px-6 py-4 font-medium text-gray-900">{{ $p->name }}</td>
              <td class="px-6 py-4 text-gray-500 font-light">{{ $p->email }}</td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                  {{ $p->role }}
                </span>
              </td>
              <td class="px-6 py-4 text-gray-400 font-light">
                {{ optional($p->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
              </td>
              <td class="px-6 py-4">
                <div class="flex justify-end gap-2">
                  <a href="{{ route('admin.petugas.edit', $p) }}"
                     class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Edit
                  </a>
                  <form action="{{ route('admin.petugas.destroy', $p) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus petugas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-light">Belum ada data petugas.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(method_exists($petugas, 'links'))
      <div class="px-6 py-4 border-t border-gray-100">
        {{ $petugas->links() }}
      </div>
    @endif
  </div>

</div>

{{-- MODAL LAPORAN --}}
<div id="petugasLaporanModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 p-4">
  <div class="w-full max-w-5xl rounded-2xl bg-white p-6 shadow-2xl max-h-[90vh] overflow-auto border border-gray-100">
    <div class="mb-4 flex items-center justify-between">
      <div>
        <h2 style="font-family:'Playfair Display',serif;" class="text-xl font-normal text-gray-900">Preview Laporan <em>Petugas</em></h2>
        <p class="text-sm text-gray-400 font-light">Tampilan laporan dokumen</p>
      </div>
      <button onclick="closePetugasLaporanModal()"
        class="rounded-lg bg-gray-100 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition">✕ Tutup</button>
    </div>

    <div id="petugasPrintArea" class="mx-auto min-h-[900px] max-w-[900px] rounded bg-white p-10 border border-gray-100">
      <div class="mb-5 text-center border-b border-gray-100 pb-5">
        <div class="text-2xl font-bold text-gray-900">Laporan Data Petugas</div>
        <div class="mt-1 text-sm text-gray-400">Daftar akun petugas perpustakaan</div>
      </div>
      <div class="mb-4 text-sm text-gray-500"><strong class="text-gray-700">Tanggal Cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</div>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-gray-50">
            <th class="border border-gray-200 px-3 py-2 text-left text-gray-600">No</th>
            <th class="border border-gray-200 px-3 py-2 text-left text-gray-600">Nama</th>
            <th class="border border-gray-200 px-3 py-2 text-left text-gray-600">Email</th>
            <th class="border border-gray-200 px-3 py-2 text-left text-gray-600">Role</th>
            <th class="border border-gray-200 px-3 py-2 text-left text-gray-600">Dibuat</th>
          </tr>
        </thead>
        <tbody>
          @forelse($petugas as $index => $item)
            <tr style="{{ $index % 2 == 0 ? 'background:#fff' : 'background:#f9fafb' }}">
              <td class="border border-gray-200 px-3 py-2 text-gray-500">{{ $index + 1 }}</td>
              <td class="border border-gray-200 px-3 py-2 font-medium text-gray-900">{{ $item->name }}</td>
              <td class="border border-gray-200 px-3 py-2 text-gray-600">{{ $item->email }}</td>
              <td class="border border-gray-200 px-3 py-2 text-gray-600">{{ $item->role }}</td>
              <td class="border border-gray-200 px-3 py-2 text-gray-500">{{ optional($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="border border-gray-200 px-3 py-4 text-center text-gray-400">Tidak ada data petugas</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4 text-sm text-gray-500"><strong class="text-gray-700">Total Petugas:</strong> {{ count($petugas) }}</div>
    </div>

    <div class="mt-5 flex justify-end gap-3">
      <button onclick="printPetugasLaporan()"
        class="rounded-lg bg-gray-100 text-gray-700 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition">🖨️ Print</button>
      <a href="{{ route('admin.petugas.laporan.download', ['q' => request('q')]) }}"
        class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">⬇️ Download PDF</a>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
function openPetugasLaporanModal() {
    const m = document.getElementById('petugasLaporanModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closePetugasLaporanModal() {
    const m = document.getElementById('petugasLaporanModal');
    m.classList.add('hidden'); m.classList.remove('flex');
}
window.addEventListener('click', e => {
    const m = document.getElementById('petugasLaporanModal');
    if (e.target === m) closePetugasLaporanModal();
});
function printPetugasLaporan() {
    const content = document.getElementById('petugasPrintArea').innerHTML;
    const w = window.open('','','width=1000,height=700');
    w.document.write(`<html><head><title>Laporan Petugas</title><style>body{font-family:Arial,sans-serif;padding:24px}table{width:100%;border-collapse:collapse;font-size:13px}th,td{border:1px solid #e5e7eb;padding:8px;text-align:left}th{background:#f9fafb}</style></head><body>${content}</body></html>`);
    w.document.close(); w.focus(); w.print();
}
</script>
@endsection