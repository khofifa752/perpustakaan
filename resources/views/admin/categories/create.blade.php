@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-2xl mx-auto px-6 py-8">

  <div class="mb-6">
    <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Tambah <em>Kategori</em></h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Masukkan nama kategori baru</p>
  </div>

  <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
    <form action="{{ route('admin.categories.store') }}" method="POST">
      @csrf

      <div class="p-6">
        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama kategori..."
          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
        @error('name')
          <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div class="p-6 flex justify-end gap-3 bg-gray-50/50 border-t border-gray-100">
        <a href="{{ route('admin.categories.index') }}"
           class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">
          Batal
        </a>
        <button type="submit"
           class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-700 transition">
          💾 Simpan
        </button>
      </div>

    </form>
  </div>
</div>
@endsection