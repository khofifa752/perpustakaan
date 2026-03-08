@extends('admin.layouts.main') 

@section('main-content') 
<div class="p-6">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold">Pengembalian</h1>
      <p class="text-gray-500">Daftar peminjaman yang sedang berjalan (status: Disetujui)</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
      {{ session('success') }}
    </div>
  @endif

  <form class="mb-4 flex gap-2" method="GET" action="{{ route('admin.pengembalian.index') }}">
    <input name="q" value="{{ $q }}" class="w-full max-w-md border rounded-lg px-3 py-2"
           placeholder="Cari kode / nama peminjam / judul buku...">
    <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">Cari</button>
    <a href="{{ route('admin.pengembalian.index') }}" class="px-4 py-2 rounded-lg border">Reset</a>
  </form>

  <div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
      <thead class="bg-gray-50">
        <tr class="text-left text-sm text-gray-600">
          <th class="p-4">Kode</th>
          <th class="p-4">Peminjam</th>
          <th class="p-4">Judul Buku</th>
          <th class="p-4">Status</th>
          <th class="p-4 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bookings as $b)
          <tr class="border-t">
            <td class="p-4">{{ $b->code }}</td>
            <td class="p-4">{{ $b->user->name ?? '-' }}</td>
            <td class="p-4">{{ $b->book->title ?? '-' }}</td>
            <td class="p-4">
              <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                {{ $b->status }}
              </span>
            </td>
            <td class="p-4 text-right flex gap-2 justify-end">
              <a href="{{ route('admin.pengembalian.show', $b->id) }}"
                 class="px-3 py-2 rounded-lg border">
                Detail
              </a>

              <form action="{{ route('admin.pengembalian.konfirmasi', $b->id) }}" method="POST"
                    onsubmit="return confirm('Yakin buku sudah dikembalikan?')">
                @csrf
                @method('PATCH')
                <button class="px-3 py-2 rounded-lg bg-green-600 text-white">
                  Dikembalikan
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="p-6 text-center text-gray-500">
              Tidak ada pengembalian.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $bookings->links() }}
  </div>
</div>
@endsection