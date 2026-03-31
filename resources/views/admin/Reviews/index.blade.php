@extends('admin.layouts.main')

@section('main-content')
<div class="w-full">

  {{-- HEADER --}}
  <div class="mb-6">
    <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Kelola Ulasan</h1>
    <p class="text-sm text-gray-400 mt-1 font-light">Daftar semua rating & ulasan buku</p>
  </div>

  {{-- ALERT --}}
  @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
      ✅ {{ session('success') }}
    </div>
  @endif

  {{-- SEARCH --}}
  <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" class="flex gap-2 w-full sm:max-w-xl">
      <div class="relative flex-1">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
          </svg>
        </span>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari user / judul buku / ulasan..."
          class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-sm focus:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-100">
      </div>
      <button type="submit" class="px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-700 transition">Cari</button>
      <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Reset</a>
    </form>
    <div class="text-sm text-gray-400 font-light">
      Total: <span class="font-medium text-gray-700">{{ $reviews->total() }}</span> ulasan
    </div>
  </div>

  {{-- TABLE --}}
  <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="border-b border-gray-100">
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Buku</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">User</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Rating</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Ulasan</th>
            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-widest">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($reviews as $r)
            <tr class="hover:bg-gray-50/60 transition">
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ $r->book->title ?? '-' }}</div>
                <div class="text-xs text-gray-400 font-light">{{ $r->created_at->format('d-m-Y H:i') }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ $r->user->name ?? '-' }}</div>
                <div class="text-xs text-gray-400 font-light">{{ $r->user->email ?? '' }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-medium text-yellow-600">
                  {{ $r->rating }} / 5 ⭐
                </span>
              </td>
              <td class="px-6 py-4 text-gray-500 font-light max-w-xs">
                {{ $r->comment ?? '-' }}
              </td>
              <td class="px-6 py-4 text-right">
                <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}"
                      onsubmit="return confirm('Yakin hapus ulasan ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-light">Belum ada ulasan.</td>
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