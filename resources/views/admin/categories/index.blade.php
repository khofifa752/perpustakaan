@extends('admin.layouts.main')

@section('main-content')

<div class="max-w-5xl mx-auto px-6 py-8">

  {{-- HEADER --}}
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Kelola Kategori</h1>
      <p class="text-sm text-gray-400 mt-1 font-light">Kelola kategori buku perpustakaan</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-700 transition shadow-sm">
      + Tambah Kategori
    </a>
  </div>

  {{-- ALERT --}}
  @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
      ✅ {{ session('success') }}
    </div>
  @endif

  {{-- TABLE --}}
  <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="border-b border-gray-100">
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Nama Kategori</th>
            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-widest w-48">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($categories as $category)
          <tr class="hover:bg-gray-50/60 transition">
            <td class="px-6 py-4 font-medium text-gray-800">{{ $category->name }}</td>
            <td class="px-6 py-4">
              <div class="flex items-center justify-center gap-2">
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-300 transition">
                  Edit
                </a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin hapus kategori ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="2" class="px-6 py-10 text-center text-gray-400 font-light">Belum ada kategori.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection