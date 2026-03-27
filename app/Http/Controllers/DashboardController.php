<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku       = Book::count();
        $totalUser       = User::where('role', 'peminjam')->count();
        $peminjamAktif   = Booking::whereIn('status', ['Diajukan', 'Disetujui', 'Dipinjam'])->count();
        $bukuTerlambat   = Booking::where('status', 'Dipinjam')
                                ->whereNotNull('expired_at')
                                ->where('expired_at', '<', Carbon::today())
                                ->count();

        $peminjamTerbaru = Booking::with(['user', 'book'])
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.index', compact(
            'totalBuku',
            'totalUser',
            'peminjamAktif',
            'bukuTerlambat',
            'peminjamTerbaru'
        ));
    }

    public function laporanBuku()
    {
        $books = Book::with('category')->latest()->get();
        return view('admin.laporan.buku', compact('books'));
    }
}