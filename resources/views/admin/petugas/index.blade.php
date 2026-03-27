@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-7xl mx-auto px-6 py-8">

  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        Kelola Petugas
      </h1>
      <p class="text-gray-500 mt-1">
        Tambah, edit, reset password, dan hapus petugas
      </p>
    </div>

    <div class="flex items-center gap-3">
      <button
        type="button"
        onclick="openPetugasLaporanModal()"
        class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-green-700 transition"
      >
        Generate Laporan
      </button>

      <a href="{{ route('admin.petugas.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition">
        <span class="text-lg">＋</span>
        Tambah Petugas
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="mt-8 rounded-2xl bg-white shadow-md border border-gray-100 p-6">
    <form method="GET" action="{{ route('admin.petugas.index') }}"
          class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

      <div class="relative w-full md:max-w-md">
        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm">
          🔎
        </span>
        <input type="text" name="q" value="{{ request('q') }}"
              placeholder="Cari nama atau email..."
              class="w-full rounded-xl border border-gray-300 pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition">
      </div>

      <div class="flex gap-3 justify-end">
        <button type="submit"
                class="rounded-xl bg-gray-800 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-900 transition">
          Cari
        </button>

        <a href="{{ route('admin.petugas.index') }}"
          class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
          Reset
        </a>
      </div>

    </form>
  </div>

  <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-lg border border-gray-100">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">

        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
          <tr>
            <th class="px-6 py-4 text-left">Nama</th>
            <th class="px-6 py-4 text-left">Email</th>
            <th class="px-6 py-4 text-left">Role</th>
            <th class="px-6 py-4 text-left">Dibuat</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          @forelse($petugas as $p)
            <tr class="hover:bg-gray-50 transition">

              <td class="px-6 py-4 font-medium text-gray-800">
                {{ $p->name }}
              </td>

              <td class="px-6 py-4 text-gray-600">
                {{ $p->email }}
              </td>

              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                  {{ $p->role }}
                </span>
              </td>

              <td class="px-6 py-4 text-gray-500">
                {{ optional($p->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
              </td>

              <td class="px-6 py-4">
                <div class="flex justify-end gap-2">

                  <a href="{{ route('admin.petugas.edit', $p) }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 transition">
                    Edit
                  </a>

                  <form action="{{ route('admin.petugas.destroy', $p) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus petugas ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                      class="rounded-lg bg-red-600 px-4 py-2 text-xs font-semibold text-white hover:bg-red-700 transition">
                      Hapus
                    </button>
                  </form>

                </div>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                Belum ada data petugas.
              </td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>

    @if(method_exists($petugas, 'links'))
      <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $petugas->links() }}
      </div>
    @endif
  </div>

</div>

<div
  id="petugasLaporanModal"
  class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4"
>
  <div class="w-full max-w-5xl rounded-2xl bg-[#f3f4f6] p-5 shadow-2xl max-h-[90vh] overflow-auto">
    <div class="mb-4 flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Preview Laporan Petugas</h2>
        <p class="text-sm text-gray-500">Tampilan laporan seperti file dokumen</p>
      </div>

      <button
        type="button"
        onclick="closePetugasLaporanModal()"
        class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600"
      >
        Tutup
      </button>
    </div>

    <div
      id="petugasPrintArea"
      class="mx-auto min-h-[900px] max-w-[800px] rounded bg-white p-10 shadow"
    >
      <div class="mb-5 text-center">
        <div class="text-2xl font-bold">Laporan Data Petugas</div>
        <div class="mt-1 text-sm text-gray-500">Daftar akun petugas perpustakaan</div>
      </div>

      <div class="mb-4 text-sm">
        <strong>Tanggal Cetak:</strong>
        {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
      </div>

      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 px-3 py-2 text-left">No</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Nama</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Email</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Role</th>
            <th class="border border-gray-300 px-3 py-2 text-left">Dibuat</th>
          </tr>
        </thead>
        <tbody>
          @forelse($petugas as $index => $item)
            <tr>
              <td class="border border-gray-300 px-3 py-2">{{ $index + 1 }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->name }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->email }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->role }}</td>
              <td class="border border-gray-300 px-3 py-2">
                {{ optional($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="border border-gray-300 px-3 py-4 text-center">
                Tidak ada data petugas
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-4 text-sm">
        <strong>Total Petugas:</strong> {{ count($petugas) }}
      </div>
    </div>

    <div class="mt-5 flex justify-end gap-3">
      <button
        type="button"
        onclick="printPetugasLaporan()"
        class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600"
      >
        Print
      </button>

      <a
        href="{{ route('admin.petugas.laporan.download', ['q' => request('q')]) }}"
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
function openPetugasLaporanModal() {
    const modal = document.getElementById('petugasLaporanModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closePetugasLaporanModal() {
    const modal = document.getElementById('petugasLaporanModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

window.addEventListener('click', function (e) {
    const modal = document.getElementById('petugasLaporanModal');
    if (e.target === modal) {
        closePetugasLaporanModal();
    }
});

function printPetugasLaporan() {
    const content = document.getElementById('petugasPrintArea').innerHTML;
    const printWindow = window.open('', '', 'width=900,height=700');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Laporan Petugas</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 24px;
                    color: #111827;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
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
            </style>
        </head>
        <body>${content}</body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>
@endsection