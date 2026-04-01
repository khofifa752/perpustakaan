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
        .stat-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.08); }
        .card-pink   { background: #FDE8EC; }
        .card-blue   { background: #E4EDFB; }
        .card-green  { background: #DFF7EE; }
        .card-yellow { background: #FDF4DC; }
        .icon-pink   { background: #F2C4CE; color: #9B3A52; }
        .icon-blue   { background: #C4D9F2; color: #2A5A9B; }
        .icon-green  { background: #C4F2DE; color: #1E7A52; }
        .icon-yellow { background: #F2E8C4; color: #7A5C1E; }
        .num-pink    { color: #9B3A52; }
        .num-blue    { color: #2A5A9B; }
        .num-green   { color: #1E7A52; }
        .num-yellow  { color: #7A5C1E; }
    </style>
</head>
<body class="overflow-hidden">
<div class="flex h-screen overflow-hidden w-screen">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        @include('admin.partials.topbar')

        <main class="flex-1 overflow-y-auto p-6 overflow-x-hidden bg-gray-50/50">

            {{-- HEADING --}}
            <div class="mb-6">
                <h1 class="serif text-2xl font-normal text-gray-900">Ringkasan <em>Dashboard</em></h1>
                <p class="text-sm text-gray-400 mt-1 font-light">Pantau aktivitas perpustakaan secara real-time</p>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

                <div class="stat-card card-blue rounded-2xl p-5 border border-blue-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-blue-400 uppercase tracking-widest">Total Buku</p>
                            <h3 class="serif text-4xl font-normal num-blue mt-2">{{ number_format($totalBuku) }}</h3>
                            <p class="text-xs text-blue-400 mt-2 font-light">
                                Stok tersedia: <span class="font-medium">{{ number_format($totalStock) }}</span>
                            </p>
                        </div>
                        <div class="icon-blue w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-book text-base"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card card-green rounded-2xl p-5 border border-green-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-green-500 uppercase tracking-widest">Peminjaman Aktif</p>
                            <h3 class="serif text-4xl font-normal num-green mt-2">{{ number_format($peminjamAktif) }}</h3>
                            <p class="text-xs text-green-400 mt-2 font-light">Sedang berjalan</p>
                        </div>
                        <div class="icon-green w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exchange-alt text-base"></i>
                        </div>
                    </div>
                </div>

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

                <div class="stat-card card-yellow rounded-2xl p-5 border border-yellow-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium text-yellow-600 uppercase tracking-widest">Buku Terlambat</p>
                            <h3 class="serif text-4xl font-normal num-yellow mt-2">{{ number_format($bukuTerlambat) }}</h3>
                            <p class="text-xs text-yellow-500 mt-2 font-light">
                                @if($bukuTerlambat > 0) Belum dikembalikan @else Semua tepat waktu @endif
                            </p>
                        </div>
                        <div class="icon-yellow w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-base"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- PEMINJAMAN TERBARU --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="serif text-lg font-normal text-gray-900">Peminjaman <em>Terbaru</em></h3>
                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="text-xs font-medium text-gray-400 hover:text-gray-700 transition">
                       Lihat Semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead>
                            <tr class="text-xs uppercase text-gray-400 tracking-wider border-b border-gray-50">
                                <th class="pb-3 font-medium text-left">Peminjam</th>
                                <th class="pb-3 font-medium text-left">Buku</th>
                                <th class="pb-3 font-medium text-left">Waktu</th>
                                <th class="pb-3 font-medium text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($peminjamTerbaru as $p)
                            @php
                                $sc = match($p->status) {
                                    'Dipinjam','Disetujui','Diajukan'  => 'bg-green-50 text-green-600',
                                    'Menunggu Pengembalian'             => 'bg-blue-50 text-blue-500',
                                    'Dikembalikan'                      => 'bg-gray-50 text-gray-500',
                                    'Ditolak'                           => 'bg-red-50 text-red-500',
                                    default                             => 'bg-yellow-50 text-yellow-600',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-semibold text-pink-500">
                                                {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="font-medium text-gray-800 truncate max-w-[120px]">{{ $p->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 pr-4 text-gray-500 truncate max-w-[180px]">
                                    {{ $p->book->title ?? '-' }}
                                </td>
                                <td class="py-3 pr-4 text-gray-400 font-light whitespace-nowrap">
                                    {{ $p->created_at->diffForHumans() }}
                                </td>
                                <td class="py-3">
                                    <span class="px-2.5 py-1 {{ $sc }} text-xs rounded-full font-medium whitespace-nowrap">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-sm text-gray-300 font-light">
                                    Belum ada peminjaman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>
</body>
</html>