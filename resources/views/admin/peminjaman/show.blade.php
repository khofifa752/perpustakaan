@extends('admin.layouts.main')

@section('main-content')
<div class="w-full">

  <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">Proses Peminjaman</h1>
    <p class="text-sm text-gray-500">Tentukan status peminjaman</p>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div>
        <div class="text-gray-500">Kode</div>
        <div class="font-semibold text-gray-900">{{ $booking->code }}</div>
      </div>

      <div>
        <div class="text-gray-500">User</div>
        <div class="font-semibold text-gray-900">{{ $booking->user->name ?? '-' }}</div>
      </div>

      <div>
        <div class="text-gray-500">Judul Buku</div>
        <div class="font-semibold text-gray-900">{{ $booking->book->title ?? '-' }}</div>
      </div>

      <div>
        <div class="text-gray-500">Status Sekarang</div>
        <div class="font-semibold text-gray-900">{{ $booking->status }}</div>
      </div>
    </div>

    <hr class="my-6">

    <form method="POST" action="{{ route('admin.peminjaman.updateStatus', $booking->id) }}" class="flex flex-col gap-4 max-w-sm">
      @csrf
      @method('PATCH')

      <label class="text-sm font-medium text-gray-700">Ubah Status</label>
      <select name="status"
        class="w-full rounded-lg border border-gray-200 bg-white py-2 px-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
        <!-- <option value="Diajukan" {{ $booking->status=='Diajukan' ? 'selected' : '' }}>Diajukan</option> -->
        <option value="Disetujui" {{ $booking->status=='Disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="Ditolak" {{ $booking->status=='Ditolak' ? 'selected' : '' }}>Ditolak</option>
        <!-- <option value="Dikembalikan" {{ $booking->status=='Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option> -->
      </select>

      <div class="flex gap-2">
        <button
          type="submit"
          class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
          Simpan
        </button>

        <a href="{{ route('admin.peminjaman.index') }}"
          class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
          Kembali
        </a>
      </div>
    </form>
  </div>

</div>
@endsection
