@extends('admin.layouts.main')

@section('main-content')

<div class="p-6">

    <!-- Judul -->
    <h1 class="text-2xl font-bold mb-6">
        Detail User
    </h1>


    <!-- Card info user -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">

        <div class="space-y-2">

            <p>
                <span class="font-semibold text-gray-700">Nama:</span>
                <span class="text-gray-900">{{ $user->name }}</span>
            </p>

            <p>
                <span class="font-semibold text-gray-700">Email:</span>
                <span class="text-gray-900">{{ $user->email }}</span>
            </p>

            <p>
                <span class="font-semibold text-gray-700">Tanggal Daftar:</span>
                <span class="text-gray-900">
                    {{ $user->created_at->format('d-m-Y') }}
                </span>
            </p>

            <p>
                <span class="font-semibold text-gray-700">Total Pinjam:</span>
                <span class="text-gray-900">
                    {{ $bookings->count() }}
                </span>
            </p>

        </div>

    </div>



    <!-- Riwayat -->
    <h2 class="text-xl font-semibold mb-4">
        Riwayat Peminjaman
    </h2>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900">
                        {{ $booking->book->title ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        @if($booking->status == 'dipinjam')
                            <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                Dipinjam
                            </span>
                        @elseif($booking->status == 'dikembalikan')
                            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                Dikembalikan
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                {{ $booking->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $booking->created_at->format('d-m-Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        Belum ada peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

           <div class="flex justify-end mb-6">
            <a href="{{ route('admin.users.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                ← Kembali
            </a>
            </div>
    </div>
</div>

@endsection