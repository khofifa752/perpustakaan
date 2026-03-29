<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $totalPinjam     = $user->bookings()->count();
        $sedangDipinjam  = $user->bookings()->whereIn('status', ['Diajukan', 'Disetujui', 'Dipinjam'])->count();
        $totalKoleksi    = $user->collections()->count();

        return view('profile.index', compact('user', 'totalPinjam', 'sedangDipinjam', 'totalKoleksi'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

       return back()->with('profile_success', 'Profil berhasil diperbarui!');
    }
}