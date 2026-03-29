<aside class="w-64 bg-white flex flex-col h-full border-r border-gray-100" style="font-family:'Inter',sans-serif;">

    <!-- Logo -->
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gray-900 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-book-open text-white text-sm"></i>
            </div>
            <div>
                <h1 style="font-family:'Playfair Display',serif;" class="text-base font-normal text-gray-900 leading-tight">PerpusKita</h1>
                <p class="text-xs text-gray-400 font-light">Admin Dashboard</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        <!-- Menu Item -->
        @php
            function navClass($active) {
                return $active 
                    ? 'bg-gray-900 text-white shadow-sm' 
                    : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900 hover:shadow-sm';
            }
        @endphp

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.dashboard')) }}">
            <i class="fas fa-chart-line w-4 text-center"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.books.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.books.*')) }}">
            <i class="fas fa-book w-4 text-center"></i>
            <span>Buku</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.categories.*')) }}">
            <i class="fas fa-tags w-4 text-center"></i>
            <span>Kategori</span>
        </a>

        <a href="{{ route('admin.peminjaman.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.peminjaman.*')) }}">
            <i class="fas fa-exchange-alt w-4 text-center"></i>
            <span>Peminjaman</span>
            @php
                $aktif = \App\Models\Booking::whereIn('status',['Diajukan','Disetujui','Dipinjam','Menunggu Pengembalian'])->count();
            @endphp
            @if($aktif > 0)
                <span class="ml-auto text-xs bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full font-medium">
                    {{ $aktif }}
                </span>
            @endif
        </a>

        <a href="{{ route('admin.pengembalian.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.pengembalian.*')) }}">
            <i class="fas fa-undo w-4 text-center"></i>
            <span>Pengembalian</span>
            @php
                $menunggu = \App\Models\Booking::where('status','Menunggu Pengembalian')->count();
            @endphp
            @if($menunggu > 0)
                <span class="ml-auto text-xs bg-blue-100 text-blue-500 px-2 py-0.5 rounded-full font-medium">
                    {{ $menunggu }}
                </span>
            @endif
        </a>

        <a href="{{ route('admin.riwayat.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.riwayat.*')) }}">
            <i class="fas fa-history w-4 text-center"></i>
            <span>Riwayat Peminjaman</span>
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.reviews.*')) }}">
            <i class="fas fa-star w-4 text-center"></i>
            <span>Kelola Ulasan</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.users.*')) }}">
            <i class="fas fa-users w-4 text-center"></i>
            <span>Kelola Pengguna</span>
        </a>

        @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('admin.petugas.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition {{ navClass(request()->routeIs('admin.petugas.*')) }}">
            <i class="fas fa-user-tie w-4 text-center"></i>
            <span>Kelola Petugas</span>
        </a>
        @endif

    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex w-full items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-50 hover:text-red-600 transition">
                <i class="fas fa-sign-out-alt w-4 text-center"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>