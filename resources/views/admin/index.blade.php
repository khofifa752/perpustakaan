<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #FFFFFF; }
        * { scrollbar-width: thin; }
        *::-webkit-scrollbar { width: 5px; }
        *::-webkit-scrollbar-track { background: transparent; }
        *::-webkit-scrollbar-thumb { background: #E8E8E8; border-radius: 3px; }
        *::-webkit-scrollbar-thumb:hover { background: #C8C8C8; }

        .serif { font-family: 'Playfair Display', serif; }

        .link { transition: all 0.25s ease; }
        .link:hover {
            background: rgba(0,0,0,.04);
            border-left: 3px solid #1A1A1A;
            padding-left: calc(1rem + 1px);
        }
        .link.active {
            background: rgba(0,0,0,.06);
            border-left: 3px solid #1A1A1A;
            color: #1A1A1A;
            font-weight: 600;
        }

        /* stat cards */
        .stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,.08);
        }

        /* pastel card colors */
        .card-pink  { background: #FDE8EC; }
        .card-blue  { background: #E4EDFB; }
        .card-green { background: #DFF7EE; }
        .card-yellow{ background: #FDF4DC; }

        .icon-pink  { background: #F2C4CE; color: #9B3A52; }
        .icon-blue  { background: #C4D9F2; color: #2A5A9B; }
        .icon-green { background: #C4F2DE; color: #1E7A52; }
        .icon-yellow{ background: #F2E8C4; color: #7A5C1E; }

        .num-pink  { color: #9B3A52; }
        .num-blue  { color: #2A5A9B; }
        .num-green { color: #1E7A52; }
        .num-yellow{ color: #7A5C1E; }

        /* chart bar */
        .bar { background: #F2C4CE; border-radius: 6px 6px 0 0; transition: background .2s; }
        .bar:hover { background: #E8A0B0; }
    </style>
</head>
<body class="overflow-hidden">
<div class="flex h-screen overflow-hidden w-screen">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        @include('admin.partials.topbar')

        <main class="flex-1 overflow-y-auto p-6 overflow-x-hidden bg-gray-50/50">

            {{-- ── HEADING ── --}}
            <div class="mb-6">
                <h1 class="serif text-2xl font-normal text-gray-900">Ringkasan <em>Dashboard</em></h1>
                <p class="text-sm text-gray-400 mt-1 font-light">Pantau aktivitas perpustakaan secara real-time</p>
            </div>

            {{-- ── STAT CARDS ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

                {{-- Total Buku --}}
                <div class="stat-card card-blue rounded-2xl p-5 border border-blue-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-blue-400 uppercase tracking-widest">Total Buku</p>
                            <h3 class="serif text-4xl font-normal num-blue mt-2">{{ number_format($totalBuku) }}</h3>
                            <p class="text-xs text-blue-400 mt-2 font-light">Seluruh koleksi</p>
                        </div>
                        <div class="icon-blue w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-book text-base"></i>
                        </div>
                    </div>
                </div>

                {{-- Peminjaman Aktif --}}
                <div class="stat-card card-green rounded-2xl p-5 border border-green-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-green-500 uppercase tracking-widest">Peminjaman Aktif</p>
                            <h3 class="serif text-4xl font-normal num-green mt-2">{{ number_format($peminjamAktif) }}</h3>
                            <p class="text-xs text-green-400 mt-2 font-light">Sedang berjalan</p>
                        </div>
                        <div class="icon-green w-11 h-11 rounded-xl flex items-center justify-content-center flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exchange-alt text-base"></i>
                        </div>
                    </div>
                </div>

                {{-- Total User --}}
                <div class="stat-card card-pink rounded-2xl p-5 border border-pink-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-pink-400 uppercase tracking-widest">Total User</p>
                            <h3 class="serif text-4xl font-normal num-pink mt-2">{{ number_format($totalUser) }}</h3>
                            <p class="text-xs text-pink-400 mt-2 font-light">Pengguna terdaftar</p>
                        </div>
                        <div class="icon-pink w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-base"></i>
                        </div>
                    </div>
                </div>

                {{-- Buku Terlambat --}}
                <div class="stat-card card-yellow rounded-2xl p-5 border border-yellow-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-yellow-600 uppercase tracking-widest">Buku Terlambat</p>
                            <h3 class="serif text-4xl font-normal num-yellow mt-2">{{ number_format($bukuTerlambat) }}</h3>
                            <p class="text-xs text-yellow-500 mt-2 font-light">
                                @if($bukuTerlambat > 0) Perlu tindakan @else Semua tepat waktu @endif
                            </p>
                        </div>
                        <div class="icon-yellow w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-base"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── TABEL & POPULER ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Peminjaman Terbaru --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="serif text-lg font-normal text-gray-900">Peminjaman <em>Terbaru</em></h3>
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-700 transition">Lihat Semua →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($peminjamTerbaru as $p)
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name ?? 'U') }}&background=F2C4CE&color=9B3A52&bold=true&font-size=0.4"
                                 alt="User" class="w-10 h-10 rounded-full flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $p->user->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400 truncate font-light">
                                    {{ $p->status === 'Dikembalikan' ? 'Mengembalikan' : 'Meminjam' }}
                                    "{{ $p->book->title ?? '-' }}"
                                </p>
                                <p class="text-xs text-gray-300 mt-0.5">{{ $p->created_at->diffForHumans() }}</p>
                            </div>
                            @php
                                $sc = match($p->status) {
                                    'Dipinjam','Disetujui','Diajukan' => 'bg-green-50 text-green-600',
                                    'Dikembalikan' => 'bg-gray-50 text-gray-500',
                                    'Ditolak'      => 'bg-red-50 text-red-500',
                                    default        => 'bg-yellow-50 text-yellow-600',
                                };
                            @endphp
                            <span class="px-2.5 py-1 {{ $sc }} text-xs rounded-full font-medium whitespace-nowrap">
                                {{ $p->status }}
                            </span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-300 text-center py-6 font-light">Belum ada peminjaman.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Buku Populer --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="serif text-lg font-normal text-gray-900">Buku <em>Populer</em></h3>
                        <a href="{{ route('admin.books.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-700 transition">Lihat Semua →</a>
                    </div>
                    <div class="space-y-3">
                        @php
                            $iconBg = ['bg-blue-50 text-blue-400','bg-pink-50 text-pink-400','bg-green-50 text-green-400','bg-yellow-50 text-yellow-500','bg-purple-50 text-purple-400'];
                            $popularBooks = \App\Models\Booking::select('book_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                                ->with('book.categories')
                                ->groupBy('book_id')
                                ->orderByDesc('total')
                                ->take(5)
                                ->get();
                        @endphp
                        @forelse($popularBooks as $i => $item)
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 rounded-xl {{ $iconBg[$i % count($iconBg)] }} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-book text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $item->book->title ?? '-' }}</p>
                               <p class="text-xs text-gray-400 mt-0.5 font-light">{{ $item->book->categories->pluck('name')->join(', ') ?? '-' }}</p>
                            </div>
                            <span class="text-xs font-medium text-gray-400 whitespace-nowrap">{{ $item->total }}x</span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-300 text-center py-6 font-light">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ── BAR CHART ── --}}
            <div class="mt-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="serif text-lg font-normal text-gray-900">Statistik <em>Peminjaman</em></h3>
                    <span class="text-xs text-gray-400 font-light">7 hari terakhir</span>
                </div>
                @php
                    $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i));
                    $chartData = $days->map(fn($d) => [
                        'label' => $d->translatedFormat('D'),
                        'count' => \App\Models\Booking::whereDate('created_at', $d->toDateString())->count(),
                    ]);
                    $maxCount = $chartData->max('count') ?: 1;
                @endphp
                <div class="h-52 flex items-end gap-3">
                    @foreach($chartData as $day)
                    @php $pct = max(5, round(($day['count'] / $maxCount) * 100)); @endphp
                    <div class="flex-1 flex flex-col items-center gap-1.5">
                        <span class="text-xs font-medium text-gray-400">{{ $day['count'] ?: '' }}</span>
                        <div class="bar w-full" style="height: {{ $pct }}%" title="{{ $day['label'] }}: {{ $day['count'] }} peminjaman"></div>
                        <span class="text-xs font-medium text-gray-400">{{ $day['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
</body>
</html>