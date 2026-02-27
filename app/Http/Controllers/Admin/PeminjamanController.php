<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['book','user'])->latest()->get();
        return view('admin.peminjaman.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['book','user']);
        return view('admin.peminjaman.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
{
    $request->validate([
        'status' => 'required|in:Diajukan,Disetujui,Ditolak,Dikembalikan',
    ]);

    DB::transaction(function () use ($request, $booking) {

      
        $oldStatus = $booking->status;
        $newStatus = $request->status;

       
        if ($oldStatus !== 'Disetujui' && $newStatus === 'Disetujui') {
            $book = Book::lockForUpdate()->findOrFail($booking->book_id);

            if ($book->stock <= 0) {
                abort(400, 'Stok buku habis.');
            }

            $book->decrement('stock', 1);
        }

       
        $booking->update([
            'status' => $newStatus
        ]);

        
        if ($newStatus === 'Dikembalikan' && $oldStatus !== 'Dikembalikan') {
            Book::where('id', $booking->book_id)->increment('stock', 1);
        }

        if ($request->status === 'Dikembalikan' && $oldStatus !== 'Dikembalikan') {
        $booking->update([
            'returned_at' => now(),
        ]);

        Book::where('id', $booking->book_id)->increment('stock', 1);
         }
    });

    return redirect()->route('admin.peminjaman.index')
        ->with('success', 'Status peminjaman berhasil diupdate.');
    }


    }
