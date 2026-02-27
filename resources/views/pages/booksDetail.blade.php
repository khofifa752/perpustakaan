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
            @if($book->cover)
          <img class="card-img-top" src="/storage/{{ $book->cover }}" alt="Card image cap">
          @else
          <img class="card-img-top" src="{{ asset('img/bookCoverDefault.png') }}" alt="Card image cap">
          @endif
          </div>
      </div>
    </div>

      <!-- Information -->
      <div class="col-md-8">
          <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold">Detail Buku</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <table>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Judul : </td>
                    <td>{{$book->title}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Penulis : </td>
                    <td>{{$book->author}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Penerbit : </td>
                    <td>{{$book->publisher}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Kategori : </td>
                    <td>{{$book->category->name}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Deskripsi : </td>
                    <td>{{$book->description}}</td>
                  </tr>
                  <tr class="d-flex gap-4">
                    <td class="fw-medium">Stock : </td>
                    <td>{{$book->stock}}</td>
                  </tr>
                </table>
              </div>

              <!-- {{-- proses --}} -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold">Peminjaman</h6>
              </div>
              <div class="card-body">  
                    @if(auth()->check() && $canBorrow)
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      Pinjam Buku
                    </button>
                  @elseif(auth()->check() && !$canBorrow)
                    <div class="alert alert-warning mb-0">
                      Kamu masih punya pinjaman aktif, Kembalikan dulu supaya bisa pinjam lagi.
                    </div>
                  @else
                    <a href="{{ route('login') }}" class="btn btn-warning">Login untuk pinjam</a>
                  @endif
              </div>

{{-- ================== RATING & ULASAN (TARUH DI SINI) ================== --}}
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
  <h6 class="m-0 fw-bold">Rating & Ulasan</h6>
</div>

<div class="card-body">
  <details>
    <summary style="cursor:pointer; user-select:none;">
      <b>Rating:</b> {{ round($book->reviews_avg_rating ?? 0, 1) }}/5
      <span class="text-muted">({{ $book->reviews_count ?? 0 }} ulasan)</span>
    </summary>

   <div class="mt-3 border rounded p-2" style="max-height: 260px; overflow-y: auto;">
  @if(($book->reviews_count ?? 0) > 0)
    @foreach($book->reviews->sortByDesc('created_at')->take(20) as $r)
      <div class="border rounded p-2 mb-2 bg-white">
        <div class="d-flex justify-content-between align-items-center">
          <b class="text-dark">{{ $r->user->name ?? 'User' }}</b>
          <span class="badge bg-warning text-dark">{{ $r->rating }} ⭐</span>
        </div>

        <div class="text-muted small">
          {{ $r->created_at->translatedFormat('d F Y') }}
        </div>

        @if($r->comment)
          <div class="mt-2">
            {{ $r->comment }}
          </div>
        @else
          <div class="mt-2 text-muted">-</div>
        @endif
      </div>
    @endforeach
  @else
    <div class="text-muted">Belum ada ulasan.</div>
  @endif
</div>



 @endsection

 <!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
          Pinjam Buku: {{ $book->title }}
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-3">Apakah kamu yakin ingin meminjam buku ini?</p>

        <div class="border rounded p-3 bg-light">
          <div class="mb-1"><strong>Judul:</strong> {{ $book->title }}</div>
          <div class="mb-1"><strong>Penulis:</strong> {{ $book->author }}</div>
          <div class="mb-1"><strong>Penerbit:</strong> {{ $book->publisher }}</div>
          <div class="mb-1"><strong>Kategori:</strong> {{ $book->category->name }}</div>
          <div class="mb-0"><strong>Stok:</strong> {{ $book->stock }}</div>
        </div>

        {{-- kalau mau tampilkan deskripsi singkat --}}
        <div class="mt-3">
          <small class="text-muted">
            {{ \Illuminate\Support\Str::limit($book->description, 120) }}
          </small>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <form action="/booking" method="post" class="m-0">
          @csrf
           {{-- <input type="text" name="user_id" value="{{ auth()->user->id }}" hidden> --}}
            <input type="text" name="book_id" value="{{ $book->id }}" hidden>
            <input type="text" name="status" value="{{ 'Diajukan' }}" hidden>
            <input type="text" name="is_denda" value="{{ 0 }}" hidden>
          <button type="submit" class="btn btn-primary">Setuju Pinjam</button>
        </form>
      </div> 

    </div>
  </div>
</div>
