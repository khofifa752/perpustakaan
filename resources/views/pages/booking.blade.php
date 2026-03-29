@extends('layouts.main')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@600&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body {
  font-family: 'DM Sans', sans-serif;
  background: #f0ebe2;
}

.page-wrapper {
  max-width: 760px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem 4rem;
}

.page-title {
  font-family: 'Lora', serif;
  font-size: 1.5rem;
  font-weight: 600;
  color: #1c1610;
  margin-bottom: 1.75rem;
}

.search-bar input {
  height: 42px;
  padding: 0 1rem;
  border-radius: 10px;
  border: 1.5px solid #d4c9b5;
  background: #fff;
  font-family: inherit;
  font-size: .88rem;
  color: #2c2416;
  outline: none;
  width: 280px;
  margin-bottom: 1.75rem;
  box-shadow: 0 4px 18px rgba(44,36,22,.14);
  transition: box-shadow .2s, border .2s;
}

.search-bar input:focus {
  border-color: #8a6d45;
  box-shadow: 0 6px 24px rgba(44,36,22,.2);
}
.search-bar input::placeholder { color: #b0987a; }

.booking-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.booking-card {
  background: #d7dbdbe1;
  border-radius: 16px;
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  gap: 1.25rem;
  box-shadow: 0 6px 28px rgba(246, 245, 242, 0.14);
  transition: transform .25s, box-shadow .25s;
  animation: rise .4s ease both;
}

.booking-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 18px 44px rgba(44, 36, 22, 0.81);
}

@keyframes rise {
  from { opacity: 0; transform: translateY(12px); }
  to   { opacity: 1; transform: translateY(0); }
}

.booking-card:nth-child(2) { animation-delay: .07s; }
.booking-card:nth-child(3) { animation-delay: .14s; }
.booking-card:nth-child(4) { animation-delay: .21s; }
.booking-card:nth-child(5) { animation-delay: .28s; }

.booking-info { flex: 1; min-width: 0; }

.booking-title {
  font-family: 'Lora', serif;
  font-size: 1.05rem;
  font-weight: 600;
  color: #1c1610;
  margin-bottom: .2rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.booking-sub {
  font-size: .76rem;
  color: #a89880;
  display: flex;
  gap: .8rem;
  flex-wrap: wrap;
}

.booking-right {
  display: flex;
  align-items: center;
  gap: .65rem;
  flex-shrink: 0;
}

.status-badge {
  font-size: .7rem;
  font-weight: 700;
  letter-spacing: .06em;
  text-transform: uppercase;
  padding: 5px 12px;
  border-radius: 100px;
}

.s-diajukan    { color: #b45309; background: #fef3c7; }
.s-disetujui   { color: #166534; background: #dcfce7; }
.s-ditolak     { color: #991b1b; background: #fee2e2; }
.s-dikembalikan{ color: #44403c; background: #f5f5f4; }
.s-default     { color: #3730a3; background: #e0e7ff; }

.btn-view {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1.5px solid #e8e0d5;
  background: #faf6f0;
  color: #5c4a32;
  font-size: .85rem;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all .2s;
}

.btn-view:hover {
  background: #1c1610;
  border-color: #1c1610;
  color: #fff;
}

.empty-state {
  text-align: center;
  padding: 4rem 0;
  color: #b8a88a;
  font-size: .95rem;
}

.pagination-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1.75rem;
  flex-wrap: wrap;
  gap: .75rem;
}

.pagination-info { font-size: .78rem; color: #a89880; }
.pagination-links { display: flex; gap: .35rem; }

.page-link {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  border: none;
  background: #fff;
  border: 1.5px solid #e0d8cc;
  color: #5c4a32;
  font-size: .82rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  box-shadow: 0 4px 16px rgba(44,36,22,.12);
  transition: all .2s;
}

.page-link:hover, .page-link.active {
  background: #1c1610;
  color: #fff;
  box-shadow: none;
}

.btn-delete {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1.5px solid #d4c9b5;
  background: #faf6f0;
  color: #a89880;
  font-size: .85rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all .2s;
  cursor: pointer;
}

.btn-delete:hover {
  background: #fee2e2;
  border-color: #fecaca;
  color: #ef4444;
}
</style>
@endsection

@section('main-content')
<div class="page-wrapper">

  <h1 class="page-title">Peminjaman Saya</h1>

  <div class="search-bar">
    <input type="text" placeholder="🔍  Cari judul atau kode..." oninput="filterCards(this.value)">
  </div>

  <div class="booking-list">
    @forelse ($bookings as $booking)
      @php
        $s = strtolower($booking->status ?? '');
        $cls = match($s) {
          'diajukan'     => 's-diajukan',
          'disetujui'    => 's-disetujui',
          'ditolak'      => 's-ditolak',
          'dikembalikan' => 's-dikembalikan',
          default        => 's-default',
        };
      @endphp
      <div class="booking-card" data-search="{{ strtolower($booking->code . ' ' . ($booking->book?->title ?? '')) }}">
        <div class="booking-info">
          <div class="booking-title">{{ $booking->book?->title ?? '-' }}</div>
          <div class="booking-sub">
            <span>#{{ $booking->code }}</span>
            <span>Pinjam: {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y') }}</span>
            @if($booking->due_date)
              <span>Kembali: {{ \Carbon\Carbon::parse($booking->due_date)->translatedFormat('d M Y') }}</span>
            @endif
          </div>
        </div>
        <div class="booking-right">
          <span class="status-badge {{ $cls }}">{{ ucfirst($booking->status) }}</span>
          <a href="/booking/{{ $booking->id }}" class="btn-view" title="Lihat Detail"><i class="bi bi-eye"></i></a>

          @if($booking->status === 'Dikembalikan')
            <form action="/booking/{{ $booking->id }}" method="POST" onsubmit="return confirm('Hapus riwayat ini?')">
              @csrf
              @method('DELETE')
           <button type="submit" class="btn-delete" title="Hapus Riwayat">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          @endif
        </div>
      </div>
    @empty
      <div class="empty-state">Belum ada peminjaman.</div>
    @endforelse
  </div>

  @if($bookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="pagination-wrap">
      <span class="pagination-info">{{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} dari {{ $bookings->total() }} peminjaman</span>
      <div class="pagination-links">
        <a class="page-link" href="{{ $bookings->previousPageUrl() ?? '#' }}">‹</a>
        @foreach($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
          <a class="page-link {{ $page == $bookings->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
        @endforeach
        <a class="page-link" href="{{ $bookings->nextPageUrl() ?? '#' }}">›</a>
      </div>
    </div>
  @endif

</div>
@endsection

@section('script')
<script>
function filterCards(q) {
  q = q.toLowerCase();
  document.querySelectorAll('.booking-card').forEach(c => {
    c.style.display = c.dataset.search.includes(q) ? '' : 'none';
  });
}
</script>
@endsection