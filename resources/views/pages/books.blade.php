@extends('layouts.main')

@section('style')
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'DM Sans', sans-serif;
  background: #f5f0e8;
  padding: 2rem 2.5rem 4rem;
}

.toolbar {
  display: flex;
  justify-content: center;
  margin-bottom: 2rem;
}

.toolbar .input-group input {
  height: 42px;
  border: 1.5px solid #d4c9b5;
  background: #fff;
  font-family: inherit;
  font-size: .88rem;
  color: #2c2416;
  outline: none;
  transition: border .2s, box-shadow .2s;
}

.toolbar .input-group input:focus {
  border-color: #8a6d45;
  box-shadow: 0 0 0 3px rgba(138,109,69,.12);
  z-index: 1;
}

.toolbar .input-group input::placeholder {
  color: #b8a88a;
}

.toolbar .form-select {
  height: 42px;
  border: 1.5px solid #d4c9b5;
  font-family: inherit;
  font-size: .8rem;
  color: #5c4a32;
  flex: unset;
  width: 130px;
}

.toolbar .btn-warning {
  height: 42px;
  background: #2c2416;
  border: none;
  color: #f5f0e8;
  font-family: inherit;
  font-weight: 600;
  font-size: .85rem;
  padding: 0 1.2rem;
  transition: background .2s;
}

.toolbar .btn-warning:hover {
  background: #8a6d45;
  color: #fff;
}

.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
  gap: 1.5rem;
}

/* ✅ FIX: bikin card flex supaya tombol selalu rata bawah */
.book-card {
  border-radius: 14px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 2px 14px rgba(44,36,22,.09);
  transition: transform .25s, box-shadow .25s;
  animation: rise .45s ease both;
  text-decoration: none;

  display: flex;            /* dari block -> flex */
  flex-direction: column;
  height: 100%;
}

@keyframes rise {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

.book-card:nth-child(1) { animation-delay: .04s; }
.book-card:nth-child(2) { animation-delay: .08s; }
.book-card:nth-child(3) { animation-delay: .12s; }
.book-card:nth-child(4) { animation-delay: .16s; }
.book-card:nth-child(5) { animation-delay: .20s; }
.book-card:nth-child(6) { animation-delay: .24s; }
.book-card:nth-child(7) { animation-delay: .28s; }
.book-card:nth-child(8) { animation-delay: .32s; }

.book-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 40px rgba(44,36,22,.16);
}

/* COVER */
.book-cover {
  height: 210px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 1rem 1rem 1rem 1.25rem;
  overflow: hidden;
}

.book-cover::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 12px;
  height: 100%;
  background: rgba(0,0,0,.18);
  z-index: 1;
}

.book-cover img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.cover-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,.55) 40%, transparent 100%);
  z-index: 2;
}

.cover-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  z-index: 3;
  padding: 4px 11px;
  border-radius: 100px;
  font-size: .68rem;
  font-weight: 700;
  letter-spacing: .06em;
  text-transform: uppercase;
}

.cover-meta {
  position: relative;
  z-index: 3;
  color: rgba(255,255,255,.9);
  font-family: 'Lora', serif;
}

.cover-cat {
  font-size: .6rem;
  letter-spacing: .14em;
  text-transform: uppercase;
  opacity: .8;
  margin-bottom: .3rem;
  font-family: 'DM Sans', sans-serif;
  font-weight: 500;
}

.cover-title {
  font-size: .95rem;
  font-style: italic;
  line-height: 1.25;
  font-weight: 600;
}

/* BODY */
.book-body {
  padding: .9rem 1rem 1rem;

  display: flex;            /* ✅ FIX */
  flex-direction: column;
  flex: 1;                  /* ✅ biar ngisi sisa tinggi card */
}

/* judul tetap 2 baris, + kasih tinggi minimum biar konsisten */
.book-title {
  font-family: 'Lora', serif;
  font-size: 1rem;
  font-weight: 700;
  color: #1c1610;
  line-height: 1.3;
  margin-bottom: .15rem;

  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;

  min-height: calc(1rem * 1.3 * 2); /* ✅ FIX: kira-kira 2 baris */
}

.book-author {
  font-size: .75rem;
  color: #9a8878;
  margin-bottom: .65rem;
}

.book-meta {
  display: flex;
  align-items: center;
  gap: .5rem;
  margin-bottom: .8rem;
}

.stars {
  display: flex;
  gap: 1px;
}

.star {
  font-size: .78rem;
  color: #e0d0b8;
}

.star.on { color: #e8a020; }

.rating-val {
  font-size: .78rem;
  font-weight: 600;
  color: #5c4a32;
}

.avail {
  font-size: .68rem;
  font-weight: 600;
  padding: 2px 8px;
  border-radius: 100px;
  margin-left: auto;
}

.av-y { background: #e8f5ec; color: #2e7d4f; }
.av-n { background: #fdecea; color: #b71c1c; }

.btn-detail {
  width: 100%;
  height: 38px;
  border-radius: 8px;
  border: none;
  font-family: inherit;
  font-size: .82rem;
  font-weight: 700;
  cursor: pointer;
  color: #fff;
  background: #1c2b3a;
  transition: all .2s;

  margin-top: auto;         /* ✅ FIX: dorong tombol ke bawah */
}

.btn-detail:hover {
  background: #2e4a6a;
  transform: translateY(-1px);
}
</style>
@endsection


@section('main-content')
<div class="container my-4">

  {{-- Search & Filter --}}
  <div class="toolbar">
    <div class="col-lg-6 w-100" style="max-width:600px">
      <form action="{{ route('books.index') }}" method="get">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            placeholder="Cari buku..."
            name="searchKeyword"
            value="{{ request('searchKeyword') }}"
          >
          <select class="form-select" name="category">
            <option value="">Kategori</option>
            @foreach ($categories as $cat)
              <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          <button class="btn btn-warning" type="submit">Cari</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Book Grid --}}
  <div class="book-grid">
    @forelse ($books as $book)
      <a href="/books/{{ $book->id }}" class="book-card">

        <div class="book-cover">
          <img
            src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('img/bookCoverDefault.png') }}"
            alt="{{ $book->title }}"
          >
          <div class="cover-overlay"></div>

          @if(isset($book->badge))
            <span class="cover-badge"
              style="{{ $book->badge === 'hot' ? 'background:#ff5c35;color:#fff' : ($book->badge === 'new' ? 'background:#ffd166;color:#2c2416' : 'background:#7c5cbf;color:#fff') }}">
              {{ strtoupper($book->badge) }}
            </span>
          @endif

          <div class="cover-meta">
            <div class="cover-cat">{{ $book->category->name ?? '' }}</div>
            <div class="cover-title">{{ $book->title }}</div>
          </div>
        </div>

        <div class="book-body">
          <div class="book-title">{{ $book->title }}</div>
          <div class="book-author">{{ $book->author ?? '' }}</div>

              @php
          $avg = (float) ($book->reviews_avg_rating ?? 0);
        @endphp

        <div class="book-meta">
          <div class="stars">
            @for ($i = 1; $i <= 5; $i++)
              <span class="star {{ $avg >= $i ? 'on' : '' }}">★</span>
            @endfor
          </div>

          <span class="rating-val">
            {{ rtrim(rtrim(number_format($avg, 1), '0'), '.') }}/5
          </span>
        </div>

          <button class="btn-detail" type="button">Lihat Detail</button>
        </div>

      </a>
    @empty
      <p class="text-muted mt-3">Tidak ada buku ditemukan.</p>
    @endforelse
  </div>

</div>
@endsection