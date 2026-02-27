<aside class="w-64 bg-white shadow-lg flex flex-col h-full">

    <!-- Logo -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-500 p-2 rounded-lg">
                <i class="fas fa-book-open text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Perpustakaan</h1>
                <p class="text-xs text-gray-500">Admin Dashboard</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <div class="px-3 space-y-1">
            <a href="/dashboard" class=" link active flex items-center px-4 py-3 text-gray-700 rounded-lg">
                <i class="fas fa-chart-line w-5"></i>
                <span class="ml-3 font-medium">Dashboard</span>
            </a>
            
            <a href="/dashboard/books" class=" link flex items-center px-4 py-3 text-gray-700 rounded-lg">
                <i class="fas fa-book w-5"></i>
                <span class="ml-3 font-medium">Buku</span>
            </a>
            
            
            <a href="{{ route('admin.categories.index') }}"
               class="link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags w-5"></i>
                <span class="ml-3 font-medium">Kategori</span>
            </a>

            <a href="{{ route('admin.peminjaman.index') }}" class="link flex items-center px-4 py-3 text-gray-700 rounded-lg">
                <i class="fas fa-exchange-alt w-5"></i>
                <span class="ml-3 font-medium">Peminjaman</span>
            </a>

             <a href="{{ route('admin.pengembalian.index') }}" class="link flex items-center px-4 py-3 text-gray-700 rounded-lg">
                <i class="fas fa-exchange-alt w-5"></i>
                <span class="ml-3 font-medium">Pengembalian</span>
            </a>

             <a href="{{ route('admin.reviews.index') }}" class="link flex items-center px-4 py-3 text-gray-700 rounded-lg">
                <i class="fas fa-users w-5"></i>
                <span class="ml-3 font-medium">Kelola Ulasan</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="link flex items-center px-4 py-3 text-gray-700 rounded-lg">
                <i class="fas fa-users w-5"></i>
                <span class="ml-3 font-medium">Kelola Pengguna</span>
            </a>
            
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.petugas.index') }}"
                class="link flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition">

                    <i class="fas fa-user-tie w-5"></i>

                    <span class="ml-3 font-medium">
                        Kelola Petugas
                    </span>

                </a>
            @endif
            
        </div>
    </nav>

    <!-- Logout -->
   <div class="p-4 border-t border-gray-200">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="flex w-full items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50">
            <i class="fas fa-sign-out-alt w-5"></i>
            <span class="ml-3 font-medium">Logout</span>
        </button>
    </form>
</div>


</aside>