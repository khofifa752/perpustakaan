@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-3xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-semibold text-gray-800 mb-1">Tambah Petugas</h1>
  <p class="text-gray-500 mb-6">Buat akun petugas baru</p>

  @if($errors->any())
    <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-200">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <div class="bg-white rounded-xl shadow-md">
    <form action="{{ route('admin.petugas.store') }}" method="POST" class="divide-y divide-gray-200">
      @csrf

      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Nama</label>
        <input name="name" value="{{ old('name') }}"
          class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 outline-none">
      </div>

      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
        <input name="email" value="{{ old('email') }}"
          class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 outline-none">
      </div>

      <div class="p-6">
        <label class="block text-sm font-medium text-gray-600 mb-2">Password</label>
        <input type="password" name="password"
          class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 outline-none">
        <p class="text-xs text-gray-500 mt-2">Minimal 6 karakter</p>
      </div>

      <div class="p-6 flex justify-end gap-3">
        <a href="{{ route('admin.petugas.index') }}"
           class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
          Batal
        </a>
        <button class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection