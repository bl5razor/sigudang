@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-2 text-gray-800">
    Dashboard User
</h1>

<p class="mb-6 text-gray-600">
    Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan peminjaman Anda.
</p>

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

    <div style="background-color: royalblue; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Barang Tersedia</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalBarangTersedia }}
        </p>
    </div>

    <div style="background-color: green; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Peminjaman Saya</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalPeminjamanSaya }}
        </p>
    </div>

    <div style="background-color: orange; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Sedang Dipinjam</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $sedangDipinjam }}
        </p>
    </div>

    <div style="background-color: red; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Total Denda Saya</h2>
        <p style="font-size: 30px; font-weight: bold; margin-top: 12px;">
            Rp {{ number_format($totalDendaSaya, 0, ',', '.') }}
        </p>
    </div>

</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">

    <div class="p-4 border-b">
        <h2 class="text-xl font-bold text-gray-800">
            Riwayat Peminjaman Terbaru
        </h2>
    </div>

    <table class="w-full min-w-[900px]">

        <thead>

            <tr class="bg-gray-300 text-gray-800">
                <th class="p-4 text-center">No</th>
                <th class="p-4 text-center">Barang</th>
                <th class="p-4 text-center">Jumlah</th>
                <th class="p-4 text-center">Tanggal Pinjam</th>
                <th class="p-4 text-center">Tanggal Kembali</th>
                <th class="p-4 text-center">Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($riwayatTerbaru as $peminjaman)

                <tr class="border-b hover:bg-gray-100">

                    <td class="p-4 text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->barang->nama_barang }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->jumlah_pinjam }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->tanggal_pinjam }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->tanggal_kembali }}
                    </td>

                    <td class="p-4 text-center">

                        @if ($peminjaman->status == 'menunggu')

                            <span style="background-color: orange; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Menunggu
                            </span>

                        @elseif ($peminjaman->status == 'dipinjam')

                            <span style="background-color: green; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Dipinjam
                            </span>

                        @elseif ($peminjaman->status == 'ditolak')

                            <span style="background-color: red; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Ditolak
                            </span>

                        @elseif ($peminjaman->status == 'dikembalikan')

                            <span style="background-color: blue; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Dikembalikan
                            </span>

                        @else

                            <span style="background-color: gray; color: white;"
                                class="px-3 py-1 rounded shadow">
                                {{ ucfirst($peminjaman->status) }}
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="p-6 text-center text-gray-500">
                        Belum ada riwayat peminjaman
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection