<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'peminjam')
            ->withCount('bookings')
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $bookings = Booking::where('user_id', $user->id)->latest()->get();

        return view('admin.users.show', compact('user', 'bookings'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->status == 'aktif') {
            $user->status = 'nonaktif';
        } else {
            $user->status = 'aktif';
        }

        $user->save();

        return redirect()->back()->with('success', 'Status user berhasil diubah');
    }

    public function laporanPdf(Request $request)
    {
        $q = $request->query('q');

        $users = User::where('role', 'peminjam')
            ->withCount('bookings')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.users.laporan-pdf', compact('users'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-user.pdf');
    }
}