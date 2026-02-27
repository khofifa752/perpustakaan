@extends('admin.layouts.main')

@section('main-content')
<div class="p-6">
  <h1 class="text-2xl font-bold mb-4">Detail Pengembalian</h1>

  <div class="bg-white rounded-xl shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <div class="text-gray-500 text-sm">Kode</div>
        <div class="font-semibold">{{ $booking->code }}</div>
      </div>
      <div>
        <div class="text-gray-500 text-sm">Status</div>
        <div class="font-semibold">{{ $booking->status }}</div>
      </div>
      <div>
        <div>
      <div class="text-gray-500 text-sm">Tanggal Pengembalian</div>
      <div class="font-semibold">
       {{ $booking->returned_at 
        ? $booking->returned_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') 
        : '-' }}
      </div>
    </div>
        <div class="text-gray-500 text-sm">Peminjam</div>
        <div class="font-semibold">{{ $booking->user->name ?? '-' }}</div>
      </div>
      <div>
        <div class="text-gray-500 text-sm">Buku</div>
        <div class="font-semibold">{{ $booking->book->title ?? '-' }}</div>
      </div>
    </div>

    <div class="mt-6 flex gap-2">
      <a href="{{ route('admin.pengembalian.index') }}" class="px-4 py-2 rounded-lg border">
        Kembali
      </a>

      <form action="{{ route('admin.pengembalian.kembalikan', $booking->id) }}" method="POST"
            onsubmit="return confirm('Yakin buku sudah dikembalikan?')">
        @csrf
        @method('PATCH')
        <button class="px-4 py-2 rounded-lg bg-green-600 text-white">
          Tandai Dikembalikan
        </button>
      </form>
    </div>
  </div>
</div>
@endsection