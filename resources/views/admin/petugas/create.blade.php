@extends('admin.layouts.main')

@section('main-content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="mb-6">
      <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Tambah <em>Petugas</em></h1>
        <p class="mt-1 text-sm text-slate-500">Buat akun petugas baru</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('admin.petugas.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6 p-6">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                        Nama
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama petugas"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-800 focus:outline-none focus:ring-1 focus:ring-slate-800"
                    >
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email petugas"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-800 focus:outline-none focus:ring-1 focus:ring-slate-800"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-800 focus:outline-none focus:ring-1 focus:ring-slate-800"
                    >
                    <p class="mt-2 text-xs text-slate-500">Minimal 6 karakter</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                <a href="{{ route('admin.petugas.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection