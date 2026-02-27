@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-4xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-semibold text-gray-800 mb-1">Tambah Buku</h1>
  <p class="text-gray-500 mb-6">Masukkan data buku baru</p>

  <div class="bg-white rounded-xl shadow-md">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">

      @csrf

      {{-- Judul --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
      </div>

      {{-- Penulis --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Penulis</label>
        <input type="text" name="author" value="{{ old('author') }}"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
      </div>

      {{-- Penerbit --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Penerbit</label>
        <input type="text" name="publisher" value="{{ old('publisher') }}"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
      </div>

      {{-- Kategori --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Kategori</label>
        <select name="category_id"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
          <option value="">-- pilih --</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}"
              {{ old('category_id') == $c->id ? 'selected' : '' }}>
              {{ $c->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Stock & Tahun --}}
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-2">Stock</label>
          <input type="number" name="stock" value="{{ old('stock') }}"
            class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                   focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                   outline-none transition">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-2">Tahun Terbit</label>
          <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
            class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                   focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                   outline-none transition">
        </div>
      </div>

      {{-- Deskripsi --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi</label>
        <textarea name="description" rows="4"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">{{ old('description') }}</textarea>
      </div>
          {{-- Cover --}}
          <div class="p-6">
            <label class="block text-sm font-medium text-gray-600 mb-2">Cover Buku</label>
            <input type="file" name="cover" accept="image/*"
              class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                    focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                    outline-none transition">
            <p class="text-xs text-gray-500 mt-2">JPG/PNG/WebP, max 2MB</p>
          </div>

      {{-- Action --}}
      <div class="p-6 flex justify-end gap-3">
        <a href="{{ route('admin.books.index') }}"
          class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
          Batal
        </a>
        <button type="submit"
          class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
          Simpan
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
