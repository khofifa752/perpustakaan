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

.form-control {
  height: 42px;
  border: 1.5px solid #d4c9b5;
  background: #fff;
  font-size: .88rem;
  color: #2c2416;
  outline: none;
}

.btn-warning {
  height: 42px;
  background: #2c2416;
  border: none;
  color: #f5f0e8;
  font-weight: 600;
  font-size: .85rem;
  padding: 0 1.2rem;
}

.btn-warning:hover {
  background: #8a6d45;
}

.category-pill {
  display: inline-block;
  padding: 6px 12px;
  font-size: 12px;
  border-radius: 999px;
  background: #eee;
  color: #444;
  transition: 0.2s;
  cursor: pointer;
}

.category-checkbox:checked + .category-pill {
  background: #2c2416;
  color: #fff;
}

.category-pill:hover {
  background: #d4c9b5;
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
}

.book-author {
  font-size: .75rem;
  color: gray;
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
}

.bookmark-btn {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: rgba(255,255,255,0.9);
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  transition: .2s;
  z-index: 2;
}

.bookmark-btn:hover {
  background: #fff;
  transform: scale(1.1);
}

.bookmark-btn.saved {
  background: #fef3c7;
}
</style>
@endsection


@section('main-content')
<div class="container my-4">

  <div class="toolbar">
    <div style="max-width:800px; width:100%">
      <form id="filterForm" action="{{ route('books.index') }}" method="GET">
        <div style="display:flex; gap:10px; margin-bottom:12px;">
          <input
            type="text"
            name="searchKeyword"
            value="{{ request('searchKeyword') }}"
            placeholder="Cari buku..."
            class="form-control">
          <button class="btn-warning">Cari</button>
        </div>

        <div style="display:flex; flex-wrap:wrap; gap:8px;">
          @foreach ($categories as $cat)
            <label>
              <input
                type="checkbox"
                name="categories[]"
                value="{{ $cat->id }}"
                class="category-checkbox"
                hidden
                {{ in_array($cat->id, request('categories', [])) ? 'checked' : '' }}
              >
              <span class="category-pill">{{ $cat->name }}</span>
            </label>
          @endforeach
        </div>
      </form>
    </div>
  </div>

  <div class="book-grid">
    @forelse ($books as $book)
      @php
        $avgRating = $book->reviews->avg('rating') ?? 0;
        $isSaved = auth()->check()
          ? $book->collections->where('user_id', auth()->id())->isNotEmpty()
          : false;
      @endphp

      <div class="book-card-wrap">
        <a href="/books/{{ $book->id }}" class="book-card">

          <div class="book-cover">
            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('img/bookCoverDefault.png') }}">
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

            <button class="btn-detail">Detail</button>
          </div>

        </a>

        @auth
          <button
            class="bookmark-btn {{ $isSaved ? 'saved' : '' }}"
            onclick="toggleKoleksi(this, {{ $book->id }})"
            title="{{ $isSaved ? 'Hapus dari koleksi' : 'Simpan ke koleksi' }}"
          >
            {{ $isSaved ? '🔖' : '🏷️' }}
          </button>
        @endauth
      </div>

    @empty
      <p>Tidak ada buku</p>
    @endforelse
  </div>

</div>
@endsection


@section('script')
<script>
  document.querySelectorAll('.category-checkbox').forEach(cb => {
    cb.addEventListener('change', () => {
      document.getElementById('filterForm').submit();
    });
  });

  function toggleKoleksi(btn, bookId) {
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
      btn.classList.toggle('saved', data.saved);
      btn.textContent = data.saved ? '🔖' : '🏷️';
      btn.title = data.saved ? 'Hapus dari koleksi' : 'Simpan ke koleksi';

      const badge = document.querySelector('.koleksi-badge');
      if (badge) {
        badge.textContent = data.count;
        badge.style.display = data.count > 0 ? 'inline' : 'none';
      }
    });
  }
</script>
@endsection