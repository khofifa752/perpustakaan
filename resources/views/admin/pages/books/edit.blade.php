@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-4xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-semibold text-gray-800 mb-1">Edit Buku</h1>
  <p class="text-gray-500 mb-6">Perbarui data buku yang sudah ada</p>

  <div class="bg-white rounded-xl shadow-md">
    <form action="{{ route('admin.books.update', $book) }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="divide-y divide-gray-200">
      @csrf
      @method('PUT')

      {{-- Judul --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Judul</label>
        <input type="text" name="title"
          value="{{ old('title', $book->title) }}"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
      </div>

      {{-- Penulis --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Penulis</label>
        <input type="text" name="author"
          value="{{ old('author', $book->author) }}"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
      </div>

      {{-- Penerbit --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Penerbit</label>
        <input type="text" name="publisher"
          value="{{ old('publisher', $book->publisher) }}"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">
      </div>

      {{-- Kategori --}}
    <div class="mb-3">
    <label class="form-label">Kategori</label>

    <div class="d-flex flex-wrap gap-2">
        @foreach ($categories as $cat)
            <label class="border rounded px-3 py-2" style="cursor:pointer;">
                <input 
                    type="checkbox" 
                    name="categories[]" 
                    value="{{ $cat->id }}"
                    {{ in_array($cat->id, $book->categories->pluck('id')->toArray()) ? 'checked' : '' }}
                >
                {{ $cat->name }}
            </label>
        @endforeach
    </div>
</div>
      {{-- Stock & Tahun --}}
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-2">Stock</label>
          <input type="number" name="stock"
            value="{{ old('stock', $book->stock) }}"
            class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                   focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                   outline-none transition">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-2">Tahun Terbit</label>
          <input type="number" name="tahun_terbit"
            value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
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
                 outline-none transition">{{ old('description', $book->description) }}</textarea>
      </div>

      {{-- Cover --}}
      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Cover Buku</label>

        {{-- Preview cover lama --}}
        <div class="mb-4">
          <img id="coverPreview"
               src="{{ $book->cover ? asset('storage/'.$book->cover) : asset('img/bookCoverDefault.png') }}"
               class="w-40 h-56 object-cover rounded-lg border">
        </div>

        <input type="file" name="cover" accept="image/*"
          class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">

        <p class="text-xs text-gray-500 mt-2">Upload cover baru untuk mengganti cover lama</p>
      </div>

      {{-- Action --}}
      <div class="p-6 flex justify-end gap-3">
        <a href="{{ route('admin.books.index') }}"
          class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
          Batal
        </a>
        <button type="submit"
          class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
          Update
        </button>
      </div>

    </form>
  </div>
</div>

{{-- Live preview saat pilih file --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.querySelector('input[name="cover"]');
    const preview = document.getElementById('coverPreview');

    input?.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            preview.src = URL.createObjectURL(file);
        }
    });
});
</script>

@endsection
