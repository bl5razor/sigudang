@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">
    Verifikasi Denda
</h1>

@if(session('success'))
    <div style="background-color: green; color: white;"
        class="p-4 rounded mb-4 shadow font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>
                <tr class="bg-gray-300">
                    <th class="p-4 text-center">No</th>
                    <th class="p-4 text-center">Peminjam</th>
                    <th class="p-4 text-center">Barang</th>
                    <th class="p-4 text-center">Denda</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($peminjamans as $peminjaman)

                    <tr class="border-b hover:bg-gray-100">

                        <td class="p-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->nama_peminjam }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->barang->nama_barang ?? '-' }}
                        </td>

                        <td class="p-4 text-center">
                            Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-center">
                            <span style="background-color: red; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Belum Lunas
                            </span>
                        </td>

                        <td class="p-4 text-center">

                            <form action="{{ route('admin.denda.verifikasi', $peminjaman->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin denda ini sudah dibayar?')">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                    style="background-color: green; color: white;"
                                    class="px-3 py-1 rounded shadow font-semibold">
                                    Verifikasi
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6"
                            class="p-6 text-center text-gray-500">
                            Tidak ada denda yang perlu diverifikasi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection