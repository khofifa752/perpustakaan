@extends('admin.layouts.main')

@section('main-content')

<div class="p-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        
        <h1 class="text-2xl font-bold text-gray-900">
            Kelola User
        </h1>

        <div class="relative w-full sm:max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                🔍
            </span>

            <input
                id="tableSearch"
                type="text"
                placeholder="Cari nama atau email..."
                class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >
        </div>

    </div>


    <div class="bg-white shadow-md rounded-lg overflow-hidden">

        <table class="min-w-full text-sm text-left">

            {{-- Table Head --}}
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Total Pinjam</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            {{-- Table Body --}}
            <tbody id="userTbody" class="divide-y">

                @foreach($users as $user)

                <tr class="hover:bg-gray-50">

                    <td class="px-4 py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3 font-medium text-gray-900">
                        {{ $user->name }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->bookings_count }}
                    </td>

                    <td class="px-4 py-3">

                        @if($user->status == 'aktif')

                            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition">
                            Detail
                        </a>
                        <!--
                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button class="px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded hover:bg-yellow-600 transition">
                                Blokir
                            </button>
                        </form>
                        -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
const searchInput = document.getElementById('tableSearch');
const tbody = document.getElementById('userTbody');

if (searchInput && tbody)
{
    const rows = Array.from(tbody.querySelectorAll('tr'));

    searchInput.addEventListener('input', function()
    {
        const keyword = this.value.toLowerCase();

        rows.forEach(function(row)
        {
            const text = row.innerText.toLowerCase();

            if (text.includes(keyword))
            {
                row.style.display = '';
            }
            else
            {
                row.style.display = 'none';
            }
        });
    });
}
</script>
@endsection