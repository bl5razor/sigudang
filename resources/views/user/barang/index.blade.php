@extends('layouts.dashboard')

@section('content')

    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        Daftar Barang
    </h1>

    @if (session('success'))
        <div style="background-color: green; color: white;"
            class="mb-4 p-4 rounded shadow font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-6">
        <form action="{{ route('user.barang') }}"
            method="GET"
            class="flex gap-2">

            <input type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari barang..."
                class="border rounded px-4 py-2 w-64">

            <button type="submit"
                style="background-color: black; color: white;"
                class="px-4 py-2 rounded shadow">
                Cari
            </button>

            @if (!empty($search))
                <a href="{{ route('user.barang') }}"
                    class="px-4 py-2 rounded shadow bg-gray-500 text-white">
                    Reset
                </a>
            @endif

        </form>
    </div>

    <!-- RESPONSIVE TABLE -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">

        <table class="w-full min-w-[1100px]">

            <thead>
                <tr class="bg-gray-300 text-gray-800">
                    <th class="p-4 text-center">No</th>
                    <th class="p-4 text-center">Foto</th>
                    <th class="p-4 text-center">Nama Barang</th>
                    <th class="p-4 text-center">Kategori</th>
                    <th class="p-4 text-center">Stok</th>
                    <th class="p-4 text-center">Kondisi</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($barangs as $barang)

                    <tr class="border-b hover:bg-gray-100">

                        <td class="p-4 text-center">
                            {{ $barangs->firstItem() + $loop->index }}
                        </td>

                        <td class="p-4 text-center">

                            @if ($barang->foto)

                                <img src="{{ asset('storage/' . $barang->foto) }}"
                                    class="w-20 h-16 object-cover rounded mx-auto shadow">

                            @else

                                -

                            @endif

                        </td>

                        <td class="p-4 text-center">
                            {{ $barang->nama_barang }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $barang->kategori }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $barang->stok }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $barang->kondisi }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $barang->status }}
                        </td>

                        <td class="p-4 text-center">

                            @if ($barang->stok > 0)

                                <a href="{{ route('user.peminjaman.create', $barang->id) }}"
                                    style="background-color: black; color: white;"
                                    class="px-4 py-2 rounded shadow">
                                    Pinjam
                                </a>

                            @else

                                <span class="text-red-600 font-semibold">
                                    Stok Habis
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8"
                            class="p-6 text-center text-gray-500">
                            Data barang tidak ditemukan
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $barangs->links() }}
    </div>

@endsection