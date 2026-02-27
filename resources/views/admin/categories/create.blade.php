@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-3xl mx-auto px-6 py-8">

  <h1 class="text-2xl font-semibold text-gray-800 mb-1">
    Tambah Kategori
  </h1>
  <p class="text-gray-500 mb-6">
    Masukkan nama kategori baru
  </p>

  <div class="bg-white rounded-xl shadow-md">
    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="divide-y divide-gray-200">
      @csrf

      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">
          Nama Kategori
        </label>
        <input type="text" name="name" value="{{ old('name') }}"
          class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg
                 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200
                 outline-none transition">

        @error('name')
          <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div class="p-6 flex justify-end gap-3">
        <a href="{{ route('admin.categories.index') }}"
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
