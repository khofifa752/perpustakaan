@extends('layouts.main')

@section('main-content')
  <div class="container mt-4" style="margin-bottom: 6rem">
  {{-- breadcrumb --}}
  <nav class="my-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Beranda</a></li>
      <li class="breadcrumb-item"><a href="/books" class="text-decoration-none">Koleksi Buku</a></li>
      <li class="breadcrumb-item active" aria-current="page">Title</li>
    </ol>
  </nav>

  {{-- card --}}
  <div class="row">

 <!-- Cover Image -->
    <div class="col-md-3">
      <div class="card shadow mb-4">
          <div class="card-body">
            <img src="{{ asset('img/bookCoverDefault.png') }}" class="object-fit-contain align-items-center" style="width: 100%" alt="...">
          </div>
      </div>
    </div>

      <!-- Info -->
      <div class="col-md-8">
          <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold">Detail Peminjaman</h6>
              </div>
            
              <div class="card-body">
                <table>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Kode peminjaman : </td>
                    <td>{{$booking->code}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Status : </td>
                    <td>{{$booking->status}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Waktu Pinjam : </td>
             <td>{{ $booking->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB</td>

                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Tengat Kembali : </td>
                 <td>{{ \Carbon\Carbon::parse($booking->expired_at)->translatedFormat('d F Y') }},
                  {{ $booking->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</td>

                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Stock Buku : </td>
                    <td>{{$booking->book->stock}}</td>
                  </tr>
                </table>
              </div>

            
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold">Infomasi Buku</h6>
              </div>
              <div class="card-body">

              <table>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Judul Buku : </td>
                    <td>{{$booking->book->title}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Penulis : </td>
                    <td>{{$booking->book->author}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Penerbit : </td>
                    <td>{{$booking->book->publisher}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Stock Buku : </td>
                    <td>{{$booking->book->stock}}</td>
                  </tr>
                </table>
          </div>
      </div>
  </div>
</div>

{{-- tombol cuma muncul kalau peminjaman sudah disetujui --}}
@if($booking->status === 'Disetujui')
  <form method="POST" action="{{ route('booking.ajukanPengembalian', $booking) }}"
        onsubmit="return confirm('Ajukan pengembalian buku ini?')">
    @csrf
    @method('PATCH')
    <button class="btn btn-warning">Ajukan Pengembalian</button>
  </form>
@endif

{{-- setelah diajukan: status menunggu konfirmasi --}}
@if($booking->status === 'Menunggu Pengembalian')
  <div class="alert alert-info mt-3">
    Pengembalian sudah diajukan.
    Menunggu konfirmasi petugas/admin.
  </div>
@endif

{{-- kalau sudah dikonfirmasi: baru dianggap dikembalikan --}}
@if($booking->status === 'Dikembalikan')
  <div class="alert alert-success mt-3">
    Pengembalian sudah dikonfirmasi.
  </div>
@endif

@if($booking->status === 'Dikembalikan')
  @if(!$booking->review)
    <div class="card shadow mb-4">
      <div class="card-header">
        <h6 class="m-0 fw-bold">Rating & Ulasan</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('booking.review.store', $booking) }}">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-medium">Rating</label>
            <select name="rating" class="form-select" required>
              <option value="">-- pilih --</option>
              @for($i=5;$i>=1;$i--)
                <option value="{{ $i }}">{{ $i }} ⭐</option>
              @endfor
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-medium">Ulasan (opsional)</label>
            <textarea name="comment" class="form-control" rows="3" placeholder="Tulis ulasan..."></textarea>
          </div>

          <button class="btn btn-primary">Kirim Ulasan</button>
        </form>
      </div>
    </div>
  @else
    <div class="alert alert-success">
      Kamu sudah memberi rating: <b>{{ $booking->review->rating }} ⭐</b><br>
      Ulasan: {{ $booking->review->comment ?? '-' }}
    </div>
  @endif
@endif

 @endsection

 
