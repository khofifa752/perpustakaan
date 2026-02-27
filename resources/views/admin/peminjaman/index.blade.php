@extends('admin.layouts.main')

@section('main-content')
<div class="w-full">

  {{-- Header --}}
  <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">Peminjaman</h1>
    <p class="text-sm text-gray-500">Kelola data peminjaman buku</p>
  </div>

  {{-- Toolbar --}}
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
    <div class="relative w-full sm:max-w-xl">
      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        {{-- icon search --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
        </svg>
      </span>

      
        <div class="relative w-full sm:max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                🔍
            </span>

            <input
                id="tableSearch"
                type="text"
                placeholder="Cari peminjam"
                class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >
        </div>
    </div>

    <div class="text-sm text-gray-500">
      Total: <span class="font-medium text-gray-700">{{ $bookings->count() }}</span> peminjaman
    </div>
  </div>

  {{-- Table Card --}}
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
              if ($st === 'disetujui') $badge = 'bg-green-100 text-green-700';
              if ($st === 'ditolak') $badge = 'bg-red-100 text-red-700';
            @endphp

            <tr class="hover:bg-gray-50/60">
              <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                {{ $b->code ?? '-' }}
              </td>

              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">
                  {{ $b->book->title ?? '-' }}
                </div>
                <div class="text-xs text-gray-500">
                  Book ID: {{ $b->book_id ?? '-' }}
                </div>
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
                <a href="{{ route('admin.peminjaman.show', $b->id) }}"
                class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">
                Proses 
                </a>

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
@endsection

@section('script')
<script>

const searchInput = document.getElementById('tableSearch');
const tbody = document.getElementById('bookingTbody');

if (searchInput && tbody)
{
    const rows = Array.from(tbody.querySelectorAll('tr'));

    searchInput.addEventListener('input', function()
    {
        const keyword = this.value.toLowerCase();

        rows.forEach(function(row)
        {
            const text = row.innerText.toLowerCase();

            if(text.includes(keyword))
            {
                row.style.display = '';
            }
            else
            {
                row.style.display = 'none';
            }
        });
    });
}

</script>
@endsection