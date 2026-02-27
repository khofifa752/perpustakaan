@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-7xl mx-auto px-6 py-8">

  {{-- Header --}}
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        Kelola Petugas
      </h1>
      <p class="text-gray-500 mt-1">
        Tambah, edit, reset password, dan hapus petugas
      </p>
    </div>

    <a href="{{ route('admin.petugas.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition">
      <span class="text-lg">＋</span>
      Tambah Petugas
    </a>
  </div>


  {{-- Flash Message --}}
  @if(session('success'))
    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-sm">
      {{ session('success') }}
    </div>
  @endif


  {{-- Search Card --}}
  <div class="mt-8 rounded-2xl bg-white shadow-md border border-gray-100 p-6">
    <form method="GET" action="{{ route('admin.petugas.index') }}"
          class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

      <div class="relative w-full md:max-w-md">
        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm">
          🔎
        </span>
        <input type="text" name="q" value="{{ request('q') }}"
              placeholder="Cari nama atau email..."
              class="w-full rounded-xl border border-gray-300 pl-11 pr-4 py-3 text-sm
                     focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition">
      </div>

      <div class="flex gap-3 justify-end">
        <button type="submit"
                class="rounded-xl bg-gray-800 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-900 transition">
          Cari
        </button>

        <a href="{{ route('admin.petugas.index') }}"
          class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
          Reset
        </a>
      </div>

    </form>
  </div>


  {{-- Table --}}
  <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-lg border border-gray-100">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">

        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
          <tr>
            <th class="px-6 py-4 text-left">Nama</th>
            <th class="px-6 py-4 text-left">Email</th>
            <th class="px-6 py-4 text-left">Role</th>
            <th class="px-6 py-4 text-left">Dibuat</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          @forelse($petugas as $p)
            <tr class="hover:bg-gray-50 transition">

              <td class="px-6 py-4 font-medium text-gray-800">
                {{ $p->name }}
              </td>

              <td class="px-6 py-4 text-gray-600">
                {{ $p->email }}
              </td>

              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                  {{ $p->role }}
                </span>
              </td>

              <td class="px-6 py-4 text-gray-500">
                {{ optional($p->created_at)->format('d-m-Y H:i') }}
              </td>

              <td class="px-6 py-4">
                <div class="flex justify-end gap-2">

                  <a href="{{ route('admin.petugas.edit', $p) }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 transition">
                    Edit
                  </a>

                  <form action="{{ route('admin.petugas.destroy', $p) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus petugas ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                      class="rounded-lg bg-red-600 px-4 py-2 text-xs font-semibold text-white hover:bg-red-700 transition">
                      Hapus
                    </button>
                  </form>

                </div>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                Belum ada data petugas.
              </td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($petugas, 'links'))
      <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $petugas->links() }}
      </div>
    @endif

  </div>

</div>
@endsection