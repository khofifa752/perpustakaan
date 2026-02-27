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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\ReviewAdminController;

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
    ->only(['index', 'store', 'show'])
    ->middleware('auth');

// review peminjam
Route::post('/booking/{booking}/review', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('booking.review.store');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'petugas') return redirect()->route('petugas.dashboard');

Route::patch('/booking/{booking}/ajukan-pengembalian', [BookingController::class, 'ajukanPengembalian'])
        ->name('booking.ajukanPengembalian');
    // peminjam
    return redirect()->route('home');
})->middleware('auth')->name('dashboard');


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

        //PENGEMBALIAN 
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::patch('/pengembalian/{booking}/konfirmasi', [PengembalianController::class, 'konfirmasi'])
          ->name('pengembalian.konfirmasi');
        
        // USERS
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        //KELOLA ULASAN 
        Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');
    });


// kelola petugas
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::resource('petugas', PetugasController::class)->except(['show']);
    });

require __DIR__.'/auth.php';