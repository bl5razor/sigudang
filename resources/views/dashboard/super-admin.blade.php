@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-2 text-gray-800">
    Dashboard Super Admin
</h1>

<p class="mb-6 text-gray-600">
    Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan data pengguna sistem.
</p>

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

    <div style="background-color: royalblue; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Total User</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalUser }}
        </p>
    </div>

    <div style="background-color: green; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Total Admin</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalAdmin }}
        </p>
    </div>

    <div style="background-color: orange; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Super Admin</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalSuperAdmin }}
        </p>
    </div>

    <div style="background-color: red; color: white; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Total Akun</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalAkun }}
        </p>
    </div>

</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">

    <div class="p-4 border-b">
        <h2 class="text-xl font-bold text-gray-800">
            Aktivitas Peminjaman Terbaru
        </h2>
    </div>

    <table class="w-full min-w-[800px]">

        <thead>

            <tr class="bg-gray-300 text-gray-800">
                <th class="p-4 text-center">No</th>
                <th class="p-4 text-center">Nama User</th>
                <th class="p-4 text-center">Barang</th>
                <th class="p-4 text-center">Jumlah</th>
                <th class="p-4 text-center">Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($aktivitasTerbaru as $peminjaman)

                <tr class="border-b hover:bg-gray-100">

                    <td class="p-4 text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->user->name ?? '-' }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->barang->nama_barang ?? '-' }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $peminjaman->jumlah_pinjam }}
                    </td>

                    <td class="p-4 text-center">
                        {{ ucfirst($peminjaman->status) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="p-6 text-center text-gray-500">
                        Belum ada aktivitas peminjaman
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection