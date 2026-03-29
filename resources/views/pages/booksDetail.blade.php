@extends('layouts.main')

@section('style')
<style>
body { font-family: 'DM Sans', sans-serif; background: #f5f0e8; }
.detail-wrap { max-width: 960px; margin: 0 auto; padding: 2rem 1.5rem 5rem; }
.breadcrumb-custom { display: flex; gap: 6px; font-size: .82rem; color: #8a7a65; margin-bottom: 2rem; }
.breadcrumb-custom a { color: #8a7a65; text-decoration: none; }
.breadcrumb-custom a:hover { color: #2c2416; }
.breadcrumb-custom span { color: #2c2416; font-weight: 600; }
.detail-grid { display: grid; grid-template-columns: 220px 1fr; gap: 2rem; align-items: start; }
.cover-card { border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(44,36,22,.18); position: sticky; top: 100px; }
.cover-card img { width: 100%; display: block; object-fit: cover; }
.info-stack { display: flex; flex-direction: column; gap: 1rem; }
.info-card { background: #fff; border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: 0 2px 12px rgba(44,36,22,.06); }
.card-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #b0a090; margin-bottom: .75rem; padding-bottom: .5rem; border-bottom: 1px solid #f0ebe0; }
.book-title { font-size: 1.4rem; font-weight: 700; color: #2c2416; line-height: 1.3; margin-bottom: .2rem; }
.book-author { font-size: .9rem; color: #8a7a65; margin-bottom: .9rem; }
.pills { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: .9rem; }
.pill { padding: 3px 11px; border-radius: 999px; font-size: .72rem; font-weight: 600; background: #f0ebe0; color: #5a4a35; }
.pill.ok { background: #dcfce7; color: #166534; }
.pill.low { background: #fef9c3; color: #854d0e; }
.desc { font-size: .85rem; color: #6a5a48; line-height: 1.7; }
.btn-pinjam { display: inline-flex; align-items: center; gap: 8px; background: #2c2416; color: #f5f0e8; border: none; padding: 11px 26px; border-radius: 999px; font-size: .88rem; font-weight: 600; cursor: pointer; transition: .2s; }
.btn-pinjam:hover { background: #8a6d45; }
.alert-active { background: #fef9c3; border: 1px solid #fde68a; color: #854d0e; border-radius: 12px; padding: 11px 14px; font-size: .85rem; }
.btn-login { display: inline-flex; align-items: center; gap: 8px; background: #f0ebe0; color: #2c2416; padding: 11px 26px; border-radius: 999px; font-size: .88rem; font-weight: 600; text-decoration: none; transition: .2s; }
.btn-login:hover { background: #d4c9b5; }
.rating-summary { display: flex; align-items: center; gap: 12px; margin-bottom: 1rem; }
.rating-big { font-size: 2.2rem; font-weight: 700; color: #2c2416; }
.stars { display: flex; gap: 2px; }
.star { font-size: 16px; color: #d4c9b5; }
.star.on { color: #f59e0b; }
.rating-sub { font-size: .75rem; color: #8a7a65; margin-top: 2px; }
.review-list { display: flex; flex-direction: column; gap: 8px; max-height: 280px; overflow-y: auto; padding-right: 4px; }
.review-list::-webkit-scrollbar { width: 4px; }
.review-list::-webkit-scrollbar-track { background: #f0ebe0; border-radius: 4px; }
.review-list::-webkit-scrollbar-thumb { background: #c4b49a; border-radius: 4px; }
.review-item { background: #eedac3cf; border-radius: 10px; padding: 10px 12px; }
.review-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px; }
.reviewer-name { font-weight: 600; font-size: .83rem; color: #2c2416; }
.review-badge { background: #fef3c7; color: #92400e; font-size: .72rem; font-weight: 700; padding: 2px 9px; border-radius: 999px; }
.review-date { font-size: .72rem; color: #a09080; margin-bottom: 5px; }
.review-comment { font-size: .82rem; color: #5a4a35; line-height: 1.5; }
.no-review { font-size: .85rem; color: #a09080; text-align: center; padding: 1.5rem 0; }
.modal-content { border-radius: 20px !important; border: none !important; overflow: hidden; }
.modal-header { background: #2c2416; color: #f5f0e8; border: none; padding: 1.1rem 1.5rem; }
.modal-title { font-size: .95rem; font-weight: 600; }
.btn-close { filter: invert(1); opacity: .7; }
.modal-body { padding: 1.25rem 1.5rem; }
.modal-info { background: #f5f0e8; border-radius: 12px; padding: .9rem 1.1rem; margin-bottom: .75rem; }
.modal-row { display: flex; gap: 1rem; font-size: .85rem; padding: .35rem 0; border-bottom: 1px solid #e8e1d4; }
.modal-row:last-child { border: none; }
.modal-label { color: #8a7a65; min-width: 80px; font-weight: 500; }
.modal-val { color: #2c2416; }
.modal-desc { font-size: .8rem; color: #8a7a65; line-height: 1.6; }
.modal-footer { background: #fff; border-top: 1px solid #f0ebe0; padding: .9rem 1.5rem; gap: 8px; }
.btn-cancel { padding: 9px 20px; border-radius: 999px; background: #f0ebe0; color: #2c2416; border: none; font-weight: 600; font-size: .85rem; cursor: pointer; transition: .2s; }
.btn-cancel:hover { background: #d4c9b5; }
.btn-confirm { padding: 9px 20px; border-radius: 999px; background: #2c2416; color: #f5f0e8; border: none; font-weight: 600; font-size: .85rem; cursor: pointer; transition: .2s; }
.btn-confirm:hover { background: #8a6d45; }
@media (max-width: 680px) {
  .detail-grid { grid-template-columns: 1fr; }
  .cover-card { max-width: 200px; margin: 0 auto; position: static; }
}
</style>
@endsection


@section('main-content')
<div class="detail-wrap">

  <div class="breadcrumb-custom">
    <a href="/">Beranda</a> /
    <a href="/books">Koleksi Buku</a> /
    <span>{{ $book->title }}</span>
  </div>

  <div class="detail-grid">

    <div class="cover-card">
      <img src="{{ $book->cover ? asset('storage/'.$book->cover) : asset('img/bookCoverDefault.png') }}" alt="{{ $book->title }}">
    </div>

    <div class="info-stack">

      <div class="info-card">
        <div class="book-title">{{ $book->title }}</div>
        <div class="book-author">{{ $book->author }}</div>
        <div class="pills">
          @foreach($book->categories as $cat)
            <span class="pill">{{ $cat->name }}</span>
          @endforeach
          <span class="pill">{{ $book->publisher }}</span>
          <span class="pill {{ $book->stock > 3 ? 'ok' : 'low' }}">Stok: {{ $book->stock }}</span>
        </div>
        <div class="desc">{{ $book->description }}</div>
      </div>

      <div class="info-card">
        <div class="card-label">Peminjaman</div>
        @if(auth()->check() && $canBorrow)
          <button class="btn-pinjam" data-bs-toggle="modal" data-bs-target="#modalPinjam">📖 Pinjam Buku</button>
        @elseif(auth()->check() && !$canBorrow)
          <div class="alert-active">⚠️ Kamu masih punya pinjaman aktif. Kembalikan dulu supaya bisa pinjam lagi.</div>
        @else
          <a href="{{ route('login') }}" class="btn-login">🔑 Login untuk pinjam</a>
        @endif
      </div>

      <div class="info-card">
        <div class="card-label">Rating & Ulasan</div>
        <div class="rating-summary">
          <div class="rating-big">{{ number_format($book->reviews_avg_rating ?? 0, 1) }}</div>
          <div>
            <div class="stars">
              @for($i = 1; $i <= 5; $i++)
                <span class="star {{ $i <= round($book->reviews_avg_rating ?? 0) ? 'on' : '' }}">&#9733;</span>
              @endfor
            </div>
            <div class="rating-sub">{{ $book->reviews_count ?? 0 }} ulasan</div>
          </div>
        </div>
        <div class="review-list">
          @forelse($book->reviews->sortByDesc('created_at') as $r)
            <div class="review-item">
              <div class="review-top">
                <span class="reviewer-name">{{ $r->user->name ?? 'User' }}</span>
                <span class="review-badge">{{ $r->rating }} ⭐</span>
              </div>
              <div class="review-date">{{ $r->created_at->translatedFormat('d F Y') }}</div>
              <div class="review-comment">{{ $r->comment ?? '-' }}</div>
            </div>
          @empty
            <div class="no-review">📭 Belum ada ulasan untuk buku ini.</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">📖 Konfirmasi Peminjaman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="modal-info">
          <div class="modal-row"><span class="modal-label">Judul</span><span class="modal-val">{{ $book->title }}</span></div>
          <div class="modal-row"><span class="modal-label">Penulis</span><span class="modal-val">{{ $book->author }}</span></div>
          <div class="modal-row"><span class="modal-label">Penerbit</span><span class="modal-val">{{ $book->publisher }}</span></div>
          <div class="modal-row"><span class="modal-label">Kategori</span><span class="modal-val">{{ $book->categories->pluck('name')->join(', ') }}</span></div>
          <div class="modal-row"><span class="modal-label">Stok</span><span class="modal-val">{{ $book->stock }}</span></div>
        </div>
        <div class="modal-desc">{{ \Illuminate\Support\Str::limit($book->description, 120) }}</div>
      </div>
      <div class="modal-footer">
        <button class="btn-cancel" data-bs-dismiss="modal">Batal</button>
        <form action="/booking" method="post" class="m-0">
          @csrf
          <input type="hidden" name="book_id" value="{{ $book->id }}">
          <input type="hidden" name="status" value="Diajukan">
          <input type="hidden" name="is_denda" value="0">
          <button type="submit" class="btn-confirm">✅ Ya, Pinjam!</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection