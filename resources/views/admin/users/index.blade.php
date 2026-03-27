@extends('admin.layouts.main')

@section('main-content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola User</h1>
        <p class="text-sm text-gray-500">Kelola data akun peminjam perpustakaan</p>
    </div>

    <div class="flex gap-2">
        <div style="display:flex; gap:10px;">
            <button
                type="button"
                onclick="openUserLaporanModal()"
                style="background:#16a34a; color:white; padding:12px 18px; border:none; border-radius:14px; font-weight:600; cursor:pointer;"
            >
                Generate Laporan
            </button>
        </div>
    </div>
</div>

<div id="userLaporanModal" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.45);
    z-index:9999;
    justify-content:center;
    align-items:center;
    padding:24px;
">
    <div style="
        width:100%;
        max-width:950px;
        max-height:90vh;
        overflow:auto;
        background:#f3f4f6;
        border-radius:20px;
        box-shadow:0 25px 60px rgba(0,0,0,0.25);
        padding:20px;
    ">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="margin:0; font-size:24px; font-weight:700;">Preview Laporan User</h2>
                <p style="margin:4px 0 0; color:#6b7280;">Tampilan laporan seperti file dokumen</p>
            </div>

            <button
                type="button"
                onclick="closeUserLaporanModal()"
                style="
                    background:#ef4444;
                    color:white;
                    border:none;
                    border-radius:12px;
                    padding:10px 16px;
                    font-weight:600;
                    cursor:pointer;
                "
            >
                Tutup
            </button>
        </div>

        <div id="userPrintArea" style="
            background:white;
            width:100%;
            max-width:800px;
            margin:0 auto;
            min-height:1000px;
            padding:40px;
            border-radius:8px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        ">
            <div style="text-align:center; margin-bottom:20px;">
                <div style="font-size:26px; font-weight:700;">Laporan User Perpustakaan</div>
                <div style="margin-top:6px; color:#6b7280;">Daftar akun peminjam perpustakaan</div>
            </div>

            <div style="margin-bottom:14px; font-size:14px;">
                <strong>Tanggal Cetak:</strong> {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
            </div>

            <table width="100%" cellspacing="0" cellpadding="10" style="border-collapse:collapse; font-size:14px;">
                <thead>
                    <tr style="background:#f3f4f6;">
                        <th style="border:1px solid #d1d5db;" align="left">No</th>
                        <th style="border:1px solid #d1d5db;" align="left">Nama</th>
                        <th style="border:1px solid #d1d5db;" align="left">Email</th>
                        <th style="border:1px solid #d1d5db;" align="left">Total Pinjam</th>
                        <th style="border:1px solid #d1d5db;" align="left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td style="border:1px solid #d1d5db;">{{ $index + 1 }}</td>
                            <td style="border:1px solid #d1d5db;">{{ $user->name }}</td>
                            <td style="border:1px solid #d1d5db;">{{ $user->email }}</td>
                            <td style="border:1px solid #d1d5db;">{{ $user->bookings_count ?? 0 }}</td>
                            <td style="border:1px solid #d1d5db;">
                                {{ strtolower(trim($user->status)) == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="border:1px solid #d1d5db; text-align:center;">
                                Tidak ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top:16px; font-size:14px;">
                <strong>Total User:</strong> {{ $users->count() }}
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:18px;">
            <button
                type="button"
                onclick="printUserLaporan()"
                style="
                    background:#f59e0b;
                    color:white;
                    border:none;
                    border-radius:12px;
                    padding:12px 18px;
                    font-weight:600;
                    cursor:pointer;
                "
            >
                Print
            </button>

            <a
                href="{{ route('admin.users.laporan.pdf', ['q' => request('q')]) }}"
                style="
                    background:#2563eb;
                    color:white;
                    text-decoration:none;
                    border-radius:12px;
                    padding:12px 18px;
                    font-weight:600;
                    display:inline-block;
                "
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

<div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-md">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
            🔎
        </span>

        <input
            id="tableSearch"
            type="text"
            placeholder="Cari nama / email..."
            class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
        />
    </div>

    <div class="text-sm text-gray-500">
        Total:
        <span class="font-semibold text-gray-800">
            {{ $users->count() }}
        </span> user
    </div>
</div>

<div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Total Pinjam</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="usersTbody" class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $user->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                {{ $user->bookings_count ?? 0 }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if(strtolower(trim($user->status)) == 'aktif')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a
                                    href="{{ route('admin.users.show', $user) }}"
                                    class="inline-flex items-center rounded-lg bg-blue-500 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-600 transition shadow-sm"
                                >
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
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
    document.getElementById('userLaporanModal').style.display = 'flex';
}

function closeUserLaporanModal() {
    document.getElementById('userLaporanModal').style.display = 'none';
}

window.addEventListener('click', function (e) {
    const modal = document.getElementById('userLaporanModal');
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
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>
@endsection