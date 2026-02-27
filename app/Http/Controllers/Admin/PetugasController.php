<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = User::where('role', 'petugas')->latest()->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'petugas', 
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Akun petugas berhasil dibuat.');
    }

    public function edit(User $petugas)
    {
        abort_unless($petugas->role === 'petugas', 404);
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, User $petugas)
    {
        abort_unless($petugas->role === 'petugas', 404);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($petugas->id)],
            'password' => ['nullable','string','min:6'], // opsional reset password
        ]);

        $petugas->name = $data['name'];
        $petugas->email = $data['email'];

        if (!empty($data['password'])) {
            $petugas->password = Hash::make($data['password']);
        }

        $petugas->save();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diupdate.');
    }

    public function destroy($id)
{
    $petugas = User::where('role', 'petugas')->findOrFail($id);

    $petugas->delete();

    return redirect()->route('admin.petugas.index')
        ->with('success', 'Akun petugas berhasil dihapus.');
}


}