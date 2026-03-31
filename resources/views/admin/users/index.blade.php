@extends('admin.layouts.main')

@section('main-content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 style="font-family:'Playfair Display',serif;" class="text-2xl font-normal text-gray-900">Kelola Pengguna</h1>
        <p class="text-sm text-slate-500">Kelola data akun peminjam perpustakaan</p>
    </div>

    <button
        type="button"
        onclick="openUserLaporanModal()"
        class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition"
    >
        Generate Laporan
    </button>
</div>

<div id="userLaporanModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-6">
    <div class="w-full max-w-3xl rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Preview Laporan User</h2>
                <p class="text-sm text-slate-500">Tampilan sebelum download / print</p>
            </div>

            <button
                type="button"
                onclick="closeUserLaporanModal()"
                class="text-slate-500 hover:text-red-500 text-sm"
            >
                ✕
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-auto">
            <div id="userPrintArea" class="bg-white text-sm">
                <div class="text-center mb-6">
                    <h2 class="text-lg font-semibold">Laporan User</h2>
                    <p class="text-slate-500 text-sm">Perpustakaan</p>
                </div>

                <p class="mb-4 text-xs text-slate-500">
                    Tanggal: {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
                </p>

                <table class="w-full border border-slate-300 text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="border border-slate-300 px-3 py-2 text-left">No</th>
                            <th class="border border-slate-300 px-3 py-2 text-left">Nama</th>
                            <th class="border border-slate-300 px-3 py-2 text-left">Email</th>
                            <th class="border border-slate-300 px-3 py-2 text-left">Total</th>
                            <th class="border border-slate-300 px-3 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $user)
                            <tr>
                                <td class="border border-slate-300 px-3 py-2">{{ $i + 1 }}</td>
                                <td class="border border-slate-300 px-3 py-2">{{ $user->name }}</td>
                                <td class="border border-slate-300 px-3 py-2">{{ $user->email }}</td>
                                <td class="border border-slate-300 px-3 py-2">{{ $user->bookings_count ?? 0 }}</td>
                                <td class="border border-slate-300 px-3 py-2">
                                    {{ strtolower(trim($user->status)) == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-slate-300 px-3 py-4 text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <p class="mt-4 text-sm">
                    <strong>Total:</strong> {{ $users->count() }} user
                </p>
            </div>
        </div>

        <div class="flex justify-end gap-2 border-t bg-slate-50 px-6 py-4">
            <button
                type="button"
                onclick="printUserLaporan()"
                class="rounded-xl bg-amber-500 px-4 py-2 text-sm text-white hover:bg-amber-600"
            >
                Print
            </button>

            <a
                href="{{ route('admin.users.laporan.pdf', ['q' => request('q')]) }}"
                class="rounded-xl bg-slate-900 px-4 py-2 text-sm text-white hover:bg-slate-800"
            >
                Download PDF
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
@endif

<div class="mb-4 flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
    <input
        id="tableSearch"
        type="text"
        placeholder="Cari nama / email..."
        class="w-full sm:max-w-md rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-slate-800 focus:outline-none focus:ring-1 focus:ring-slate-800"
    />

    <span class="text-sm text-slate-500">
        Total <span class="font-semibold text-slate-800">{{ $users->count() }}</span> user
    </span>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 font-medium">
                <tr>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Total</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="usersTbody" class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs">
                                {{ $user->bookings_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(strtolower(trim($user->status)) == 'aktif')
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-700">Aktif</span>
                            @else
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs text-red-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a
                                href="{{ route('admin.users.show', $user) }}"
                                class="rounded-lg bg-slate-900 px-3 py-2 text-xs text-white hover:bg-slate-800"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-slate-500">
                            Belum ada data user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script>
const searchInput = document.getElementById('tableSearch');
const tbody = document.getElementById('usersTbody');
const modal = document.getElementById('userLaporanModal');

if (searchInput && tbody) {
    const rows = Array.from(tbody.querySelectorAll('tr'));

    searchInput.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase();

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
        });
    });
}

function openUserLaporanModal() {
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeUserLaporanModal() {
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

window.addEventListener('click', function(e) {
    if (e.target === modal) {
        closeUserLaporanModal();
    }
});

function printUserLaporan() {
    const content = document.getElementById('userPrintArea').innerHTML;
    const printWindow = window.open('', '', 'width=900,height=700');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Laporan User</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 24px;
                    color: #111827;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }
                th, td {
                    border: 1px solid #d1d5db;
                    padding: 8px;
                    text-align: left;
                    vertical-align: top;
                }
                th {
                    background: #f3f4f6;
                }
            </style>
        </head>
        <body>${content}</body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>
@endsection