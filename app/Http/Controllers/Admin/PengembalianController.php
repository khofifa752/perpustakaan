<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $bookings = Booking::with(['book', 'user'])
           
            ->where('status', 'Menunggu Pengembalian')
            ->when($q, function ($query) use ($q) {
                $query->where('code', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('book', function ($b) use ($q) {
                        $b->where('title', 'like', "%{$q}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengembalian.index', compact('bookings', 'q'));
    }

    public function show(Booking $booking)
    {
        
        abort_unless($booking->status === 'Menunggu Pengembalian', 404);

        $booking->load(['book', 'user']);
        return view('admin.pengembalian.show', compact('booking'));
    }

    public function kembalikan(Booking $booking)
    {
        
        abort_unless($booking->status === 'Menunggu Pengembalian', 404);

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'Dikembalikan',
                'returned_at' => now(), 
            ]);

           
            Book::where('id', $booking->book_id)->increment('stock', 1);
        });

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }

    
}