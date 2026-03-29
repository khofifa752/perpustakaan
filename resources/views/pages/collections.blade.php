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

.page-header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.page-header h1 {
  font-size: 1.8rem;
  font-weight: 700;
  color: #2c2416;
  margin-bottom: 4px;
}

.page-header p {
  font-size: .9rem;
  color: #8a7a65;
}

.page-header .count-badge {
  display: inline-block;
  background: #2c2416;
  color: #f5f0e8;
  font-size: .75rem;
  font-weight: 600;
  padding: 3px 12px;
  border-radius: 999px;
  margin-top: 8px;
}

.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
  gap: 1.5rem;
}

.book-card-wrap {
  position: relative;
}

.book-card {
  border-radius: 14px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 2px 14px rgba(44,36,22,.09);
  transition: .25s;
  text-decoration: none;
  display: flex;
  flex-direction: column;
}

.book-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(44,36,22,.15);
}

.book-cover {
  height: 210px;
  position: relative;
}

.book-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.cover-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,.6), transparent);
}

.cover-meta {
  position: absolute;
  bottom: 10px;
  left: 10px;
  color: #fff;
}

.cover-title {
  font-size: .9rem;
  font-weight: bold;
}

.book-body {
  padding: 10px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.book-title {
  font-size: 1rem;
  font-weight: bold;
  color: #2c2416;
}

.book-author {
  font-size: .75rem;
  color: gray;
  margin-bottom: 4px;
}

.star-row {
  display: flex;
  align-items: center;
  gap: 2px;
  margin: 4px 0 8px;
}

.star { color: #d4c9b5; font-size: 13px; }
.star.filled { color: #f59e0b; }
.rating-count { font-size: 11px; color: #999; margin-left: 3px; }

.btn-detail {
  margin-top: auto;
  background: #1c2b3a;
  color: white;
  border: none;
  height: 36px;
  border-radius: 6px;
  cursor: pointer;
  font-size: .85rem;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-detail:hover {
  background: #2d4461;
  color: #fff;
}

.remove-btn {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: rgba(255,255,255,0.92);
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  transition: .2s;
  z-index: 2;
}

.remove-btn:hover {
  background: #fee2e2;
  transform: scale(1.1);
}

.empty-state {
  grid-column: 1 / -1;
  text-align: center;
  padding: 4rem 2rem;
}

.empty-state .empty-icon {
  font-size: 3.5rem;
  margin-bottom: 1rem;
  display: block;
}

.empty-state h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #2c2416;
  margin-bottom: 6px;
}

.empty-state p {
  font-size: .88rem;
  color: #8a7a65;
  margin-bottom: 1.2rem;
}

.btn-browse {
  display: inline-block;
  background: #2c2416;
  color: #f5f0e8;
  padding: 10px 24px;
  border-radius: 999px;
  font-size: .88rem;
  font-weight: 600;
  text-decoration: none;
  transition: .2s;
}

.btn-browse:hover {
  background: #8a6d45;
  color: #fff;
}

.toast-notif {
  position: fixed;
  bottom: 24px;
  right: 24px;
  background: #2c2416;
  color: #f5f0e8;
  padding: 10px 20px;
  border-radius: 10px;
  font-size: .85rem;
  font-weight: 500;
  opacity: 0;
  transform: translateY(10px);
  transition: .3s;
  z-index: 9999;
  pointer-events: none;
}

.toast-notif.show {
  opacity: 1;
  transform: translateY(0);
}
</style>
@endsection


@section('main-content')
<div class="container my-4">

  {{-- HEADER --}}
  <div class="page-header">
    <h1>🔖 Koleksi Saya</h1>
    <p>Buku-buku yang kamu simpan untuk dipinjam nanti</p>
    <span class="count-badge">{{ $collections->count() }} buku tersimpan</span>
  </div>

  {{-- GRID --}}
  <div class="book-grid" id="collectionGrid">
    @forelse ($collections as $col)
      @php
        $book = $col->book;
        $avgRating = $book->reviews->avg('rating') ?? 0;
      @endphp

      <div class="book-card-wrap" id="wrap-{{ $col->id }}">
        <a href="/books/{{ $book->id }}" class="book-card">

          <div class="book-cover">
            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('img/bookCoverDefault.png') }}"
                 alt="{{ $book->title }}">
            <div class="cover-overlay"></div>
            <div class="cover-meta">
              <div class="cover-title">{{ $book->title }}</div>
            </div>
          </div>

          <div class="book-body">
            <div class="book-title">{{ $book->title }}</div>
            <div class="book-author">{{ $book->author }}</div>

            <div class="star-row">
              @for($i = 1; $i <= 5; $i++)
                <span class="star {{ $i <= round($avgRating) ? 'filled' : '' }}">&#9733;</span>
              @endfor
              <span class="rating-count">
                {{ $avgRating > 0 ? number_format($avgRating, 1) : 'Belum ada' }}
              </span>
            </div>

            <a href="/books/{{ $book->id }}" class="btn-detail">Detail</a>
          </div>

        </a>

        {{-- TOMBOL HAPUS DARI KOLEKSI --}}
        <button
          class="remove-btn"
          onclick="hapusKoleksi(this, {{ $book->id }}, {{ $col->id }})"
          title="Hapus dari koleksi"
        >🗑️</button>

      </div>

    @empty
      <div class="empty-state">
        <span class="empty-icon">📭</span>
        <h3>Koleksi kamu masih kosong</h3>
        <p>Simpan buku yang ingin kamu pinjam nanti dari halaman katalog.</p>
        <a href="{{ route('home') }}" class="btn-browse">Jelajahi Buku</a>
      </div>
    @endforelse
  </div>

</div>

<div class="toast-notif" id="toast">Buku dihapus dari koleksi</div>
@endsection


@section('script')
<script>
  function hapusKoleksi(btn, bookId, wrapId) {
    fetch(`/collections/toggle/${bookId}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      }
    })
    .then(res => res.json())
    .then(data => {
      // animasi hilang
      const wrap = document.getElementById(`wrap-${wrapId}`);
      wrap.style.transition = '.3s';
      wrap.style.opacity = '0';
      wrap.style.transform = 'scale(0.9)';

      setTimeout(() => {
        wrap.remove();

        // update counter header
        const badge = document.querySelector('.count-badge');
        if (badge) {
          const current = parseInt(badge.textContent) - 1;
          badge.textContent = `${current} buku tersimpan`;
        }

        // update badge navbar
        const navBadge = document.querySelector('.koleksi-badge');
        if (navBadge) {
          navBadge.textContent = data.count;
          navBadge.style.display = data.count > 0 ? 'inline' : 'none';
        }

        // tampilkan empty state kalau sudah kosong
        const grid = document.getElementById('collectionGrid');
        if (grid.querySelectorAll('.book-card-wrap').length === 0) {
          grid.innerHTML = `
            <div class="empty-state">
              <span class="empty-icon">📭</span>
              <h3>Koleksi kamu sudah kosong</h3>
              <p>Simpan buku yang ingin kamu pinjam nanti dari halaman katalog.</p>
              <a href="{{ route('home') }}" class="btn-browse">Jelajahi Buku</a>
            </div>
          `;
        }
      }, 300);

      // toast notifikasi
      const toast = document.getElementById('toast');
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2500);
    });
  }
</script>
@endsection