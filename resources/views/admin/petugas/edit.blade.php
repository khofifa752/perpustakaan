@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-2xl mx-auto px-6 py-8">

  <div class="mb-6">
    <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Edit <em>Petugas</em></h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Update data petugas (password opsional)</p>
  </div>

  @if($errors->any())
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
      <ul class="list-disc pl-4 space-y-1">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
    <form action="{{ route('admin.petugas.update', $petugas) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="divide-y divide-gray-50">

        <div class="p-6">
          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Nama</label>
          <input type="text" name="name" value="{{ old('name', $petugas->name) }}"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
        </div>

        <div class="p-6">
          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Email</label>
          <input type="email" name="email" value="{{ old('email', $petugas->email) }}"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
        </div>

        <div class="p-6">
          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Password Baru <span class="normal-case font-normal text-gray-400">(opsional)</span></label>
          <input type="password" name="password"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:bg-white transition">
          <p class="text-xs text-gray-400 mt-2">Kosongkan jika tidak ingin mengubah password</p>
        </div>

        <div class="p-6 flex justify-end gap-3 bg-gray-50/50">
          <a href="{{ route('admin.petugas.index') }}"
             class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">
            Batal
          </a>
          <button type="submit"
             class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-700 transition">
            💾 Update
          </button>
        </div>

      </div>
    </form>
  </div>
</div>
@endsection