@extends('layouts.main')

@section('style')
<style>
body { font-family: 'DM Sans', sans-serif; background: #f5f0e8; }

.detail-wrap { max-width: 960px; margin: 0 auto; padding: 2rem 1.5rem 5rem; }

.breadcrumb-custom { display: flex; gap: 6px; font-size: .82rem; color: #8a7a65; margin-bottom: 2rem; }
.breadcrumb-custom a { color: #8a7a65; text-decoration: none; }
.breadcrumb-custom a:hover { color: #2c2416; }
.breadcrumb-custom span { color: #2c2416; font-weight: 600; }

.detail-grid { display: grid; grid-template-columns: 200px 1fr; gap: 2rem; align-items: start; }

.cover-card { border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(44,36,22,.15); position: sticky; top: 100px; }
.cover-card img { width: 100%; display: block; object-fit: cover; }

.info-stack { display: flex; flex-direction: column; gap: 1rem; }

.info-card { background: #fff; border-radius: 16px; padding: 1.25rem 0rem; box-shadow: 0 2px 12px rgba(44,36,22,.06); }

.card-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #b0a090; margin-bottom: .75rem; padding-bottom: .5rem; border-bottom: 1px solid #f0ebe0; }

.info-row { display: flex; gap: 1rem; font-size: .875rem; padding: .4rem 0; border-bottom: 1px solid #303470; }
.info-row:last-child { border: none; }
.info-label { color: #8a7a65; min-width: 130px; font-weight: 500; }
.info-value { color: #2c2416; }

.status-pill { display: inline-block; padding: 3px 12px; border-radius: 999px; font-size: .75rem; font-weight: 700; }
.status-Diajukan { background: #fef9c3; color: #854d0e; }
.status-Disetujui { background: #dbeafe; color: #1e40af; }
.status-Dipinjam { background: #dcfce7; color: #166534; }
.status-Menunggu { background: #f0ebe0; color: #5a4a35; }
.status-Dikembalikan { background: #f3f4f6; color: #374151; }

.btn-ajukan { display: inline-flex; align-items: center; gap: 8px; background: #2c2416; color: #f5f0e8; border: none; padding: 11px 26px; border-radius: 999px; font-size: .88rem; font-weight: 600; cursor: pointer; transition: .2s; }
.btn-ajukan:hover { background: #8a6d45; }

.alert-info-custom { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; border-radius: 12px; padding: 11px 16px; font-size: .85rem; }
.alert-success-custom { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 12px; padding: 11px 16px; font-size: .85rem; }

.form-label-custom { font-size: .82rem; font-weight: 600; color: #5a4a35; margin-bottom: 6px; display: block; }
.form-select-custom, .form-textarea-custom { width: 100%; padding: 9px 12px; border: 1.5px solid #e8e1d4; border-radius: 10px; font-size: .875rem; color: #2c2416; background: #faf8f5; font-family: inherit; outline: none; transition: .2s; }
.form-select-custom:focus, .form-textarea-custom:focus { border-color: #8a7a65; background: #fff; }
.form-textarea-custom { resize: vertical; min-height: 90px; }
.form-group { margin-bottom: .9rem; }

.btn-kirim { display: inline-flex; align-items: center; gap: 8px; background: #2c2416; color: #f5f0e8; border: none; padding: 10px 24px; border-radius: 999px; font-size: .875rem; font-weight: 600; cursor: pointer; transition: .2s; }
.btn-kirim:hover { background: #8a6d45; }

.review-done { background: #f5f0e8; border-radius: 12px; padding: 14px 16px; }
.review-done-title { font-size: .75rem; font-weight: 700; color: #8a7a65; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 6px; }
.review-done-rating { font-size: 1.1rem; font-weight: 700; color: #2c2416; margin-bottom: 4px; }
.review-done-comment { font-size: .85rem; color: #6a5a48; }

@media (max-width: 680px) {
  .detail-grid { grid-template-columns: 1fr; }
  .cover-card { max-width: 180px; margin: 0 auto; position: static; }
}
</style>
@endsection


@section('main-content')
<div class="detail-wrap">

  <div class="breadcrumb-custom">
    <a href="/">Beranda</a> /
    <a href="/books">Koleksi Buku</a> /
    <span>Detail Peminjaman</span>
  </div>

  <div class="detail-grid">

    {{-- COVER --}}
    <div class="cover-card">
      @if($booking->book->cover)
        <img src="{{ asset('storage/'.$booking->book->cover) }}" alt="{{ $booking->book->title }}">
      @else
        <img src="{{ asset('img/bookCoverDefault.png') }}" alt="Cover">
      @endif
    </div>

    <div class="info-stack">

      {{-- DETAIL PEMINJAMAN --}}
      <div class="info-card">
        <div class="card-label">Detail Peminjaman</div>
        <div class="info-row">
          <span class="info-label">Kode Peminjaman</span>
          <span class="info-value">{{ $booking->code }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Status</span>
          <span class="info-value">
            @php
              $statusClass = match($booking->status) {
                'Diajukan' => 'status-Diajukan',
                'Disetujui' => 'status-Disetujui',
                'Dipinjam' => 'status-Dipinjam',
                'Menunggu Pengembalian' => 'status-Menunggu',
                default => 'status-Dikembalikan',
              };
            @endphp
            <span class="status-pill {{ $statusClass }}">{{ $booking->status }}</span>
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Waktu Pinjam</span>
          <span class="info-value">{{ $booking->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB</span>
        </div>
        <div class="info-row">
        <span class="info-label">Tengat Kembali</span>
        <span class="info-value">{{ \Carbon\Carbon::parse($booking->expired_at)->translatedFormat('d F Y') }}, {{ $booking->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</span>
      </div>

      @if($booking->returned_at)
      <div class="info-row">
        <span class="info-label">Waktu Dikembalikan</span>
        <span class="info-value" style="color:#166534; font-weight:600;">
          {{ $booking->returned_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
        </span>
      </div>
      @endif

      {{-- INFO BUKU --}}
      <div class="info-card">
        <div class="card-label">Informasi Buku</div>
        <div class="info-row">
          <span class="info-label">Judul</span>
          <span class="info-value">{{ $booking->book->title }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Penulis</span>
          <span class="info-value">{{ $booking->book->author }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Penerbit</span>
          <span class="info-value">{{ $booking->book->publisher }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Stok Buku</span>
          <span class="info-value">{{ $booking->book->stock }}</span>
        </div>
      </div>

      {{-- AKSI --}}
      @if($booking->status === 'Disetujui')
        <div class="info-card">
          <div class="card-label">Pengembalian</div>
          <form method="POST" action="{{ route('booking.ajukanPengembalian', $booking) }}"
                onsubmit="return confirm('Ajukan pengembalian buku ini?')">
            @csrf
            @method('PATCH')
            <button class="btn-ajukan">↩️ Ajukan Pengembalian</button>
          </form>
        </div>
      @endif

      @if($booking->status === 'Menunggu Pengembalian')
        <div class="alert-info-custom">⏳ Pengembalian sudah diajukan. Menunggu konfirmasi petugas/admin.</div>
      @endif

      @if($booking->status === 'Dikembalikan')
        <div class="alert-success-custom">✅ Pengembalian sudah dikonfirmasi.</div>
      @endif

      {{-- RATING --}}
      @if($booking->status === 'Dikembalikan')
        <div class="info-card">
          <div class="card-label">Rating & Ulasan</div>

          @if(!$booking->review)
            <form method="POST" action="{{ route('booking.review.store', $booking) }}">
              @csrf
              <div class="form-group">
                <label class="form-label-custom">Rating</label>
                <select name="rating" class="form-select-custom" required>
                  <option value="">-- pilih rating --</option>
                  @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                  @endfor
                </select>
              </div>
              <div class="form-group">
                <label class="form-label-custom">Ulasan <span style="color:#b0a090;font-weight:400;">(opsional)</span></label>
                <textarea name="comment" class="form-textarea-custom" placeholder="Tulis ulasanmu..."></textarea>
              </div>
              <button type="submit" class="btn-kirim">✉️ Kirim Ulasan</button>
            </form>
          @else
            <div class="review-done">
              <div class="review-done-title">Ulasan kamu</div>
              <div class="review-done-rating">{{ $booking->review->rating }} ⭐</div>
              <div class="review-done-comment">{{ $booking->review->comment ?? '-' }}</div>
            </div>
          @endif
        </div>
      @endif

    </div>
  </div>
</div>
@endsection