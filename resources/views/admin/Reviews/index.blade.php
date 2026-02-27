@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-6xl mx-auto px-6 py-8">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Kelola Ulasan</h1>
      <p class="text-gray-500 mt-1">Daftar semua rating & ulasan buku</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mt-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
      {{ session('success') }}
    </div>
  @endif

  <div class="mt-6 rounded-2xl bg-white shadow-sm border border-gray-200 p-4">
    <form method="GET" class="flex items-center gap-3">
      <input type="text" name="q" value="{{ request('q') }}"
        placeholder="Cari user / judul buku / ulasan..."
        class="w-full rounded-xl border border-gray-300 px-4 py-2 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200">
      <button class="rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
        Cari
      </button>
      <a href="{{ route('admin.reviews.index') }}"
        class="rounded-xl border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
        Reset
      </a>
    </form>
  </div>

  <div class="mt-5 overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-6 py-4 text-left font-semibold">Buku</th>
            <th class="px-6 py-4 text-left font-semibold">User</th>
            <th class="px-6 py-4 text-left font-semibold">Rating</th>
            <th class="px-6 py-4 text-left font-semibold">Ulasan</th>
            <th class="px-6 py-4 text-right font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($reviews as $r)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ $r->book->title ?? '-' }}</div>
                <div class="text-xs text-gray-500">{{ $r->created_at->format('d-m-Y H:i') }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ $r->user->name ?? '-' }}</div>
                <div class="text-xs text-gray-500">{{ $r->user->email ?? '' }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                  {{ $r->rating }} / 5 ⭐
                </span>
              </td>
              <td class="px-6 py-4 text-gray-700 max-w-[520px]">
                {{ $r->comment ?? '-' }}
              </td>
              <td class="px-6 py-4 text-right">
                <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}"
                      onsubmit="return confirm('Yakin hapus ulasan ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 font-medium text-red-700 hover:bg-red-100">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada ulasan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
      {{ $reviews->links() }}
    </div>
  </div>
</div>
@endsection