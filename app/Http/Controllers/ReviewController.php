<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        // hanya pemilik booking yang boleh review
        abort_unless($booking->user_id === auth()->id(), 403);

        // hanya kalau sudah dikembalikan
        abort_unless($booking->status === 'Dikembalikan', 403);

        // cegah double review
        abort_if($booking->review()->exists(), 403);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'book_id'    => $booking->book_id,
            'user_id'    => auth()->id(),
            'rating'     => $data['rating'],
            'comment'    => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan kamu sudah tersimpan.');
    }
}
