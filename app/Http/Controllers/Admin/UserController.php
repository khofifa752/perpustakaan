<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;

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
}