<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        * { scrollbar-width: thin; }
        *::-webkit-scrollbar { width: 6px; }
        *::-webkit-scrollbar-track { background: transparent; }
        *::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        *::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .link { transition: all 0.3s ease; }
        .link:hover {
            background: linear-gradient(90deg, rgba(59,130,246,0.1) 0%, transparent 100%);
            border-left: 4px solid #3b82f6;
        }
        .link.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.15) 0%, transparent 100%);
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
    </style>
</head>
<body class="bg-gray-50 overflow-hidden">
<div class="flex h-screen overflow-hidden w-screen">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        @include('admin.partials.topbar')

        <main class="flex-1 overflow-y-auto p-6 overflow-x-hidden">

            {{-- ── STAT CARDS ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                {{-- Total Buku --}}
                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Buku</p>
                            <h3 class="text-3xl font-bold mt-2">{{ number_format($totalBuku) }}</h3>
                            <p class="text-blue-100 text-xs mt-2">
                                <i class="fas fa-book"></i> Seluruh koleksi
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <i class="fas fa-book text-3xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Peminjaman Aktif --}}
                <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Peminjaman Aktif</p>
                            <h3 class="text-3xl font-bold mt-2">{{ number_format($peminjamAktif) }}</h3>
                            <p class="text-green-100 text-xs mt-2">
                                <i class="fas fa-exchange-alt"></i> Diajukan, Disetujui, Dipinjam
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <i class="fas fa-exchange-alt text-3xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Total User --}}
                <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Total User</p>
                            <h3 class="text-3xl font-bold mt-2">{{ number_format($totalUser) }}</h3>
                            <p class="text-purple-100 text-xs mt-2">
                                <i class="fas fa-users"></i> Pengguna terdaftar
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Buku Terlambat --}}
                <div class="stat-card bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium">Buku Terlambat</p>
                            <h3 class="text-3xl font-bold mt-2">{{ number_format($bukuTerlambat) }}</h3>
                            <p class="text-red-100 text-xs mt-2">
                                @if($bukuTerlambat > 0)
                                    <i class="fas fa-exclamation-circle"></i> Perlu tindakan
                                @else
                                    <i class="fas fa-check-circle"></i> Semua tepat waktu
                                @endif
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <i class="fas fa-clock text-3xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── TABEL & POPULER ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Peminjaman Terbaru --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Peminjaman Terbaru</h3>
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($peminjamTerbaru as $p)
                        <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name ?? 'U') }}&background=random"
                                 alt="User" class="w-12 h-12 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $p->user->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $p->status === 'Dikembalikan' ? 'Mengembalikan' : 'Meminjam' }}
                                    "{{ $p->book->title ?? '-' }}"
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $p->created_at->diffForHumans() }}</p>
                            </div>
                            @php
                                $statusColor = match($p->status) {
                                    'Dipinjam', 'Disetujui', 'Diajukan' => 'bg-green-100 text-green-600',
                                    'Dikembalikan'                       => 'bg-gray-100 text-gray-600',
                                    'Ditolak'                            => 'bg-red-100 text-red-600',
                                    default                              => 'bg-yellow-100 text-yellow-600',
                                };
                            @endphp
                            <span class="px-3 py-1 {{ $statusColor }} text-xs rounded-full font-medium whitespace-nowrap">
                                {{ $p->status }}
                            </span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada peminjaman.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Buku Populer --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Buku Populer</h3>
                        <a href="{{ route('admin.books.index') }}" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        @php
                            $colors = ['blue','green','purple','yellow','red'];
                            $popularBooks = \App\Models\Booking::select('book_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                                ->with('book.category')
                                ->groupBy('book_id')
                                ->orderByDesc('total')
                                ->take(5)
                                ->get();
                        @endphp
                        @forelse($popularBooks as $i => $item)
                        @php $c = $colors[$i % count($colors)]; @endphp
                        <div class="flex items-start space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="bg-{{ $c }}-100 p-3 rounded-lg flex-shrink-0">
                                <i class="fas fa-book text-{{ $c }}-600 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $item->book->title ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Kategori: {{ $item->book->category->name ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-exchange-alt"></i> {{ $item->total }} peminjaman
                                </p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ── BAR CHART 7 HARI ── --}}
            <div class="mt-6 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Peminjaman (7 Hari Terakhir)</h3>
                @php
                    $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i));
                    $chartData = $days->map(fn($d) => [
                        'label' => $d->translatedFormat('D'),
                        'count' => \App\Models\Booking::whereDate('created_at', $d->toDateString())->count(),
                    ]);
                    $maxCount = $chartData->max('count') ?: 1;
                @endphp
                <div class="h-64 flex items-end justify-between space-x-2">
                    @foreach($chartData as $day)
                    @php $pct = max(4, round(($day['count'] / $maxCount) * 100)); @endphp
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <span class="text-xs font-semibold text-gray-500">{{ $day['count'] }}</span>
                        <div class="w-full bg-blue-200 rounded-t-lg hover:bg-blue-400 transition cursor-default"
                             style="height: {{ $pct }}%"
                             title="{{ $day['label'] }}: {{ $day['count'] }} peminjaman">
                        </div>
                        <span class="text-xs font-medium text-gray-600">{{ $day['label'] }}</span>
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