@extends('admin.layouts.main')

@section('main-content')

<div class="max-w-5xl mx-auto px-6 py-8">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-gray-800">Kategori</h1>
      <p class="text-gray-500 text-sm mt-1">Kelola kategori buku perpustakaan</p>
    </div>

    <a href="{{ route('admin.categories.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
      <span class="text-lg leading-none">＋</span>
      Tambah Kategori
    </a>
  </div>


  <!-- Alert -->
  @if(session('success'))
    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
      {{ session('success') }}
    </div>
  @endif


  <!-- Card Table -->
  <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">

        <!-- Head -->
        <thead class="bg-gray-50">
          <tr class="text-left text-sm font-semibold text-gray-600">
            <th class="px-6 py-4">Nama Kategori</th>
            <th class="px-6 py-4 text-center w-48">Aksi</th>
          </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y divide-gray-100 bg-white">

          @forelse($categories as $category)
          <tr class="hover:bg-gray-50 transition">

            <!-- Nama -->
            <td class="px-6 py-4">
              <div class="font-medium text-gray-800">
                {{ $category->name }}
              </div>
            </td>

            <!-- Aksi -->
            <td class="px-6 py-4">
              <div class="flex items-center justify-center gap-2">

                
               <!-- Edit -->
              <a href="{{ route('admin.categories.edit', $category->id) }}"
                class="inline-flex items-center rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600 transition shadow-sm">
                Edit
              </a>

              <!-- Hapus -->
              <form action="{{ route('admin.categories.destroy', $category->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin hapus kategori ini?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-rose-500 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-600 transition shadow-sm">
                  Hapus
                </button>
                
                </form>

              </div>
            </td>

          </tr>

          @empty
          <tr>
            <td colspan="2" class="px-6 py-12 text-center text-gray-500">
              Belum ada kategori.
            </td>
          </tr>
          @endforelse

        </tbody>

      </table>
    </div>

  </div>

</div>

@endsection