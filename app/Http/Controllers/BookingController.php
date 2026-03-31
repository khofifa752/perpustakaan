<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        return view('pages.booking', [
            'bookings' => Booking::with(['book', 'user'])
                ->where('user_id', auth()->id())
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $masihPinjam = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['Diajukan', 'Disetujui'])
            ->exists();

        if ($masihPinjam) {
            return back()->with('error', 'Kamu masih punya peminjaman yang belum selesai. Kembalikan dulu buku sebelumnya.');
        }

        $booking = Booking::create([
            'user_id'    => Auth::id(),
            'book_id'    => $validated['book_id'],
            'status'     => 'Diajukan',
            'is_denda'   => false,
            'expired_at' => now()->addDays(7),
            'code'       => null,
        ]);

        $booking->update([
            'code' => $booking->id . $booking->book_id . $booking->created_at->format('dmy'),
        ]);

        return redirect('/booking')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function show(Booking $booking)
    {
        return view('pages.bookingDetail', [
            'booking' => $booking,
        ]);
    }

    public function ajukanPengembalian(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        if ($booking->status !== 'Disetujui') {
            return back()->with('error', 'Pengembalian hanya bisa diajukan saat status Disetujui.');
        }

        $booking->status = 'Menunggu Pengembalian';
        $booking->return_requested_at = Carbon::now('Asia/Jakarta');
        $booking->save();

        return back()->with('success', 'Pengembalian diajukan, menunggu konfirmasi petugas/admin.');
    }

    public function destroy(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);
        abort_unless(in_array($booking->status, ['Dikembalikan', 'Ditolak']), 403);

        $booking->delete();

        return back()->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }
}