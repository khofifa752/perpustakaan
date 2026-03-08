@extends('layouts.main')

@section('main-content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Detail Pengembalian</h1>

    <div class="space-y-2 mb-6">
        <div><b>Kode:</b> {{ $booking->code }}</div>
        <div><b>Peminjam:</b> {{ $booking->user->name ?? '-' }}</div>
        <div><b>Buku:</b> {{ $booking->book->title ?? '-' }}</div>
        <div><b>Status:</b> {{ $booking->status }}</div>
        <div><b>Return requested at:</b> {{ $booking->return_requested_at ?? '-' }}</div>
        <div><b>Returned at:</b> {{ $booking->returned_at ?? '-' }}</div>
    </div>

    <form action="{{ route('admin.pengembalian.konfirmasi', $booking->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
            Konfirmasi Pengembalian
        </button>
    </form>
</div>
@endsection