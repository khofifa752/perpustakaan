<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminBooksController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('partials.index');
})->name('home');

Route::resource('books', BookController::class);

/*
|--------------------------------------------------------------------------
| PEMINJAM (AUTH)
|--------------------------------------------------------------------------
*/
Route::resource('booking', BookingController::class)
    ->only(['index', 'store', 'show','destroy'])
    ->middleware('auth');


Route::patch('/booking/{booking}/ajukan-pengembalian', [BookingController::class, 'ajukanPengembalian'])
    ->middleware('auth')
    ->name('booking.ajukanPengembalian');

// review peminjam
Route::post('/booking/{booking}/review', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('booking.review.store');

//koleksi
  Route::post('/collections/toggle/{book}', [CollectionController::class, 'toggle'])->name('collections.toggle');
  Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');

//profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin' || $role === 'petugas') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('dashboard');


// admin & petugas routes
Route::prefix('dashboard')
    ->as('admin.')
    ->middleware(['auth', 'role:admin,petugas'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // BOOKS (CRUD)
        Route::get('/books', [AdminBooksController::class, 'index'])->name('books.index');
        Route::get('/books/create', [AdminBooksController::class, 'create'])->name('books.create');
        Route::post('/books', [AdminBooksController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [AdminBooksController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [AdminBooksController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [AdminBooksController::class, 'destroy'])->name('books.destroy');

        // CATEGORIES
        Route::resource('categories', CategoryController::class);

        // PEMINJAMAN
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/{booking}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::patch('/peminjaman/{booking}', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');

        // PENGEMBALIAN (ADMIN/PETUGAS KONFIRMASI)
        Route::get('/pengembalian', [PengembalianController::class, 'index'])
            ->name('pengembalian.index');

        Route::get('/pengembalian/{booking}', [PengembalianController::class, 'show'])
            ->name('pengembalian.show');

        Route::patch('/pengembalian/{booking}/konfirmasi', [PengembalianController::class, 'kembalikan'])
            ->name('pengembalian.konfirmasi');

        // RIWAYAT PEMINJAMAN
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/laporan/download', [RiwayatController::class, 'downloadPdf'])->name('riwayat.laporan.download');

        // USERS
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggle-status'])->name('users.toggleStatus');

        // KELOLA ULASAN
        Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');

        //GENERATE LAPORAN
        Route::get('/laporan/buku', [DashboardController::class, 'laporanBuku'])
        ->name('laporan.buku');

        //buku
        Route::get('/books/laporan/pdf', [AdminBooksController::class, 'laporanPdf'])
        ->name('books.laporan.pdf');

        //peminjaman
        Route::get('/peminjaman/laporan/pdf', [PeminjamanController::class, 'laporanPdf'])
        ->name('peminjaman.laporan.pdf');

        Route::get('/peminjaman/laporan/download', [PeminjamanController::class, 'downloadPdf'])
        ->name('peminjaman.laporan.download');
        
        //user
        Route::get('/users/laporan/pdf', [UserController::class, 'laporanPdf'])
        ->name('users.laporan.pdf');

        //petugas
        Route::get('/petugas/laporan/pdf', [PetugasController::class, 'laporanPdf'])
        ->name('petugas.laporan.pdf');
        Route::get('/petugas/laporan/download', [PetugasController::class, 'downloadPdf'])
        ->name('petugas.laporan.download');
    });


// kelola petugas (admin only)
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::resource('petugas', PetugasController::class)->except(['show']);
    });

require __DIR__.'/auth.php';