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

@if ($errors->has('filter'))
    <div class="mb-4 p-4 rounded shadow"
        style="background-color: red; color: white;">
        {{ $errors->first('filter') }}
    </div>
@endif

@if ($errors->any() && !$errors->has('filter'))
    <div class="mb-4 p-4 bg-red-600 text-white rounded shadow">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white p-4 rounded-xl shadow border mb-6">

    <form action="{{ route('admin.denda') }}"
        method="GET"
        class="flex flex-col lg:flex-row gap-3 lg:items-end">

        <div class="lg:w-[180px]">
            <label class="block mb-2 font-semibold">
                Tanggal Awal
            </label>
            <input type="date"
                name="tanggal_awal"
                value="{{ $tanggalAwal ?? '' }}"
                max="{{ date('Y-m-d') }}"
                class="border rounded-lg px-4 py-2 w-full">
        </div>

        <div class="lg:w-[180px]">
            <label class="block mb-2 font-semibold">
                Tanggal Akhir
            </label>
            <input type="date"
                name="tanggal_akhir"
                value="{{ $tanggalAkhir ?? '' }}"
                max="{{ date('Y-m-d') }}"
                class="border rounded-lg px-4 py-2 w-full">
        </div>

        <button type="submit"
            style="background-color: green; color: white;"
            class="h-[42px] px-6 rounded-lg shadow font-semibold">
            Filter
        </button>

        <a href="{{ route('admin.denda') }}"
            style="background-color: gray; color: white;"
            class="h-[42px] px-6 rounded-lg shadow font-semibold flex items-center justify-center">
            Reset
        </a>

    </form>

</div>

<div class="bg-white rounded-lg shadow overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full min-w-[1800px]">

            <thead>
                <tr class="bg-gray-300 text-gray-800">
                    <th class="p-4 text-center">No</th>
                    <th class="p-4 text-center">Nama Peminjam</th>
                    <th class="p-4 text-center">NIK</th>
                    <th class="p-4 text-center">Alamat Peminjam</th>
                    <th class="p-4 text-center">Barang</th>
                    <th class="p-4 text-center">Jumlah</th>
                    <th class="p-4 text-center">Catatan</th>
                    <th class="p-4 text-center">Tanggal Pinjam</th>
                    <th class="p-4 text-center">Tanggal Kembali</th>
                    <th class="p-4 text-center">Tanggal Dikembalikan</th>
                    <th class="p-4 text-center">Denda</th>
                    <th class="p-4 text-center">Status Denda</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($peminjamans as $peminjaman)

                    <tr class="border-b hover:bg-gray-100">

                        <td class="p-4 text-center">
                            {{ $peminjamans->firstItem() + $loop->index }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->nama_peminjam }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->nik }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->alamat_peminjam }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->barang->nama_barang ?? '-' }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->jumlah_pinjam }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->catatan ?? '-' }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->tanggal_pinjam }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->tanggal_kembali }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->tanggal_dikembalikan ?? '-' }}
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
                        <td colspan="13"
                            class="p-6 text-center text-gray-500">
                            Tidak ada denda yang perlu diverifikasi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-4">
    {{ $peminjamans->links() }}
</div>

@endsection