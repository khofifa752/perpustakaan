@extends('admin.layouts.main')

@section('main-content')

<div class="flex items-center justify-between mb-6">
  <div>
    <h1 class="text-2xl font-bold text-gray-800">Books</h1>
    <p class="text-sm text-gray-500">Kelola data buku perpustakaan</p>
  </div>

  <a href="{{ route('admin.books.create') }}"
     class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
    + Tambah Buku
  </a>
</div>

{{-- Alert --}}
@if(session('success'))
  <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
    {{ session('success') }}
  </div>
@endif
<div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">


  <div class="relative w-full sm:max-w-md">
    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
      🔎
    </span>

    <input
      id="tableSearch"
      type="text"
      placeholder="Cari judul / penulis / penerbit / kategori..."
      class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-sm
             focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
    />
  </div>

  <div class="text-sm text-gray-500">
    Total:
    <span class="font-semibold text-gray-800">
      {{ $books->count() }}
    </span> buku
  </div>

</div>


<!-- Table Card -->
<div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

  <div class="overflow-x-auto">

    <table class="min-w-full text-sm">
      <thead class="bg-gray-50 text-gray-600 font-semibold">
        <tr>
          <th class="px-6 py-4 text-left">Judul</th>
          <th class="px-6 py-4 text-left">Penulis</th>
          <th class="px-6 py-4 text-left">Penerbit</th>
          <th class="px-6 py-4 text-left">Kategori</th>
          <th class="px-6 py-4 text-center">Stock</th>
          <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
      </thead>

      <tbody id="booksTbody" class="divide-y divide-gray-100">

        @forelse($books as $book)

        <tr class="hover:bg-gray-50 transition">

          <td class="px-6 py-4 font-semibold text-gray-800">
            {{ $book->title }}
          </td>

          <td class="px-6 py-4 text-gray-600">
            {{ $book->author }}
          </td>
          <td class="px-6 py-4 text-gray-600">
            {{ $book->publisher }}
          </td>
          <td class="px-6 py-4">
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
              {{ $book->category?->name ?? '-' }}
            </span>
          </td>


       
          <td class="px-6 py-4 text-center">

            @if($book->stock > 5)

              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                {{ $book->stock }}
              </span>

            @elseif($book->stock > 0)

              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                {{ $book->stock }}
              </span>

            @else

              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                Habis
              </span>

            @endif

          </td>


          <!-- Aksi -->
          <td class="px-6 py-4">
            <div class="flex justify-center gap-2">
                <a href="{{ route('admin.books.edit', $book) }}"
                 class="inline-flex items-center rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600 transition shadow-sm">
                Edit
              </a>

              <form action="{{ route('admin.books.destroy', $book) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin mau hapus buku ini?')">
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
          <td colspan="6" class="px-6 py-10 text-center text-gray-500">
            Belum ada data buku
          </td>
        </tr>

        @endforelse

      </tbody>

    </table>

  </div>

</div>

@endsection



@section('script')
<script>

const searchInput = document.getElementById('tableSearch');
const tbody = document.getElementById('booksTbody');

if (searchInput && tbody)
{
  const rows = Array.from(tbody.querySelectorAll('tr'));

  searchInput.addEventListener('input', () =>
  {
    const q = searchInput.value.toLowerCase();

    rows.forEach(row =>
    {
      row.style.display =
        row.innerText.toLowerCase().includes(q)
        ? ''
        : 'none';
    });

  });
}

</script>
@endsection