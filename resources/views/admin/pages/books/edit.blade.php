@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-3xl mx-auto px-6 py-8">

  <div class="mb-6">
    <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Edit <em>Buku</em></h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Perbarui data buku yang sudah ada</p>
  </div>

  @if($errors->any())
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
      ⚠️ {{ $errors->first() }}
    </div>
  @endif

  <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="divide-y divide-gray-50">

        {{-- COVER PREVIEW --}}
        <div class="p-6 flex items-center gap-6">
          <div class="relative flex-shrink-0">
            <img id="coverPreview"
                 src="{{ $book->cover ? asset('storage/'.$book->cover) : asset('img/bookCoverDefault.png') }}"
                 class="w-28 h-40 object-cover rounded-xl border border-gray-100 shadow-sm">
            <label for="coverInput"
                   class="absolute bottom-0 right-0 w-7 h-7 bg-gray-900 text-white rounded-full flex items-center justify-center cursor-pointer border-2 border-white hover:bg-gray-700 transition text-xs">
              📷
            </label>
          </div>
          <div class="flex-1">
            <p class="text-sm font-medium text-gray-700 mb-1">Cover Buku</p>
            <p class="text-xs text-gray-400 mb-3">Upload cover baru untuk mengganti cover lama. JPG/PNG/WebP, max 2MB.</p>
            <input type="file" name="cover" id="coverInput" accept="image/*" class="hidden">
            <label for="coverInput" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition cursor-pointer">
              📁 Ganti Cover
            </label>
          </div>
        </div>

        {{-- JUDUL --}}
        <div class="p-6">
          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Judul</label>
          <input type="text" name="title" value="{{ old('title', $book->title) }}"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
        </div>

        {{-- PENULIS & PENERBIT --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Penulis</label>
            <input type="text" name="author" value="{{ old('author', $book->author) }}"
              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Penerbit</label>
            <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
          </div>
        </div>

        {{-- KATEGORI --}}
        <div class="p-6">
          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Kategori</label>
          <div class="flex flex-wrap gap-2">
            @foreach ($categories as $cat)
              @php $checked = in_array($cat->id, $book->categories->pluck('id')->toArray()); @endphp
              <label class="flex items-center gap-2 px-3 py-2 rounded-xl border cursor-pointer transition text-sm
                {{ $checked ? 'border-gray-900 bg-gray-900 text-white' : 'border-gray-200 bg-gray-50 text-gray-700 hover:bg-gray-100' }}">
                <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                       {{ $checked ? 'checked' : '' }} class="hidden"
                       onchange="this.parentElement.classList.toggle('border-gray-900'); this.parentElement.classList.toggle('bg-gray-900'); this.parentElement.classList.toggle('text-white'); this.parentElement.classList.toggle('bg-gray-50'); this.parentElement.classList.toggle('text-gray-700');">
                {{ $cat->name }}
              </label>
            @endforeach
          </div>
        </div>

        {{-- STOCK & TAHUN --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Stok</label>
            <input type="number" name="stock" value="{{ old('stock', $book->stock) }}"
              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
          </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="p-6">
          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Deskripsi</label>
          <textarea name="description" rows="4"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition resize-none">{{ old('description', $book->description) }}</textarea>
        </div>

        {{-- ACTION --}}
        <div class="p-6 flex justify-end gap-3 bg-gray-50/50">
          <a href="{{ route('admin.books.index') }}"
             class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">
            Batal
          </a>
          <button type="submit"
             class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-700 transition">
            💾 Update Buku
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('coverInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) document.getElementById('coverPreview').src = URL.createObjectURL(file);
});
</script>
@endsection