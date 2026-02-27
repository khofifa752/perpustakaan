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
        body {
            font-family: 'Inter', sans-serif;
        }
        * {
            scrollbar-width: thin;
        }
        *::-webkit-scrollbar {
            width: 6px;
        }
        *::-webkit-scrollbar-track {
            background: transparent;
        }
        *::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        *::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .link {
            transition: all 0.3s ease;
        }
        .link:hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            border-left: 4px solid #3b82f6;
        }
        .link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, transparent 100%);
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50 overflow-hidden">
    <div class="flex h-screen overflow-hidden w-screen">
        <!-- Include Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Include Topbar -->
            @include('admin.partials.topbar')

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6 overflow-x-hidden">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Buku -->
                    <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Buku</p>
                                <h3 class="text-3xl font-bold mt-2">1,245</h3>
                                <p class="text-blue-100 text-xs mt-2">
                                    <i class="fas fa-arrow-up"></i> 12% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <i class="fas fa-book text-3xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Peminjaman Aktif -->
                    <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Peminjaman Aktif</p>
                                <h3 class="text-3xl font-bold mt-2">86</h3>
                                <p class="text-green-100 text-xs mt-2">
                                    <i class="fas fa-arrow-down"></i> 5% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <i class="fas fa-exchange-alt text-3xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total User -->
                    <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Total User</p>
                                <h3 class="text-3xl font-bold mt-2">342</h3>
                                <p class="text-purple-100 text-xs mt-2">
                                    <i class="fas fa-arrow-up"></i> 8% dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <i class="fas fa-users text-3xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Buku Terlambat -->
                    <div class="stat-card bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm font-medium">Buku Terlambat</p>
                                <h3 class="text-3xl font-bold mt-2">12</h3>
                                <p class="text-red-100 text-xs mt-2">
                                    <i class="fas fa-exclamation-circle"></i> Perlu tindakan
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <i class="fas fa-clock text-3xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Popular Books -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Borrowing -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Peminjaman Terbaru</h3>
                            <a href="#" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" 
                                     alt="User" class="w-12 h-12 rounded-full">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">Budi Santoso</p>
                                    <p class="text-xs text-gray-500">Meminjam "Pemrograman Laravel"</p>
                                    <p class="text-xs text-gray-400 mt-1">2 jam yang lalu</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Aktif</span>
                            </div>
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=random" 
                                     alt="User" class="w-12 h-12 rounded-full">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">Siti Nurhaliza</p>
                                    <p class="text-xs text-gray-500">Meminjam "Database Design"</p>
                                    <p class="text-xs text-gray-400 mt-1">5 jam yang lalu</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Aktif</span>
                            </div>
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                <img src="https://ui-avatars.com/api/?name=Ahmad+Rifai&background=random" 
                                     alt="User" class="w-12 h-12 rounded-full">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">Ahmad Rifai</p>
                                    <p class="text-xs text-gray-500">Mengembalikan "Clean Code"</p>
                                    <p class="text-xs text-gray-400 mt-1">1 hari yang lalu</p>
                                </div>
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-medium">Selesai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Books -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Buku Populer</h3>
                            <a href="#" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                <div class="bg-blue-100 p-3 rounded-lg">
                                    <i class="fas fa-book text-blue-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">Laravel untuk Pemula</p>
                                    <p class="text-xs text-gray-500 mt-1">Kategori: Pemrograman</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">24 peminjaman</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                <div class="bg-green-100 p-3 rounded-lg">
                                    <i class="fas fa-book text-green-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">Design Patterns</p>
                                    <p class="text-xs text-gray-500 mt-1">Kategori: Software Engineering</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">18 peminjaman</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                <div class="bg-purple-100 p-3 rounded-lg">
                                    <i class="fas fa-book text-purple-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">JavaScript Modern</p>
                                    <p class="text-xs text-gray-500 mt-1">Kategori: Web Development</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">15 peminjaman</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="mt-6 bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Peminjaman (7 Hari Terakhir)</h3>
                    <div class="h-64 flex items-end justify-between space-x-2">
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 60%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Sen</div>
                        </div>
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 75%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Sel</div>
                        </div>
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 85%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Rab</div>
                        </div>
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 55%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Kam</div>
                        </div>
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 90%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Jum</div>
                        </div>
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 45%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Sab</div>
                        </div>
                        <div class="flex-1 bg-blue-200 rounded-t-lg hover:bg-blue-300 transition" style="height: 30%">
                            <div class="text-center pt-2 text-xs font-semibold text-gray-700">Min</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Add interactive functionality
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