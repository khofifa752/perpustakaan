<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->query('q');
        $status = $request->query('status');

        $bookings = Booking::with(['book', 'user'])
            ->whereIn('status', ['Dikembalikan', 'Ditolak'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('code', 'like', "%{$q}%")
                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$q}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.riwayat.index', compact('bookings', 'q'));
    }

    public function downloadPdf(Request $request)
    {
        $q      = $request->query('q');
        $status = $request->query('status');

        $bookings = Booking::with(['book', 'user'])
            ->whereIn('status', ['Dikembalikan', 'Ditolak'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('code', 'like', "%{$q}%")
                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$q}%"));
                });
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.riwayat.laporan-pdf', compact('bookings', 'status'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-riwayat-peminjaman.pdf');
    }
}