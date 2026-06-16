@extends('layouts.dashboard')

@section('content')

    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        Data Barang
    </h1>

    @if (session('success'))
        <div style="background-color: green; color: white;"
            class="mb-4 p-4 rounded shadow font-semibold">

            {{ session('success') }}

        </div>
    @endif

    <!-- Header Tombol + Search -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">

        <!-- Tombol Tambah Barang -->
        <a href="{{ route('admin.barang.create') }}"
            class="inline-block px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg shadow-lg transition duration-200 text-center">
            + Tambah Barang
        </a>

        <!-- Form Search -->
        <form action="{{ route('admin.barang') }}"
            method="GET"
            class="flex flex-1 md:max-w-lg gap-2">

            <input type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="🔍 Cari barang..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit"
                class="px-5 py-2 bg-black hover:bg-gray-800 text-white rounded-lg shadow">
                Cari
            </button>

            @if (!empty($search))
                <a href="{{ route('admin.barang') }}"
                    class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow">
                    Reset
                </a>
            @endif

        </form>

    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

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

                        <tr class="border-b hover:bg-gray-100 align-middle">

                            <td class="p-4 text-center align-middle">
                                {{ $barangs->firstItem() + $loop->index }}
                            </td>

                            <td class="p-4 text-center align-middle">

                                @if ($barang->foto)

                                    <img src="{{ asset('storage/' . $barang->foto) }}"
                                        class="w-20 h-16 object-cover rounded mx-auto shadow">

                                @else

                                    -

                                @endif

                            </td>

                            <td class="p-4 text-center align-middle font-medium">
                                {{ $barang->nama_barang }}
                            </td>

                            <td class="p-4 text-center align-middle">
                                {{ $barang->kategori }}
                            </td>

                            <td class="p-4 text-center align-middle">

                                @if ($barang->stok == 0)

                                    <span style="background-color: red; color: white;"
                                        class="px-3 py-1 rounded shadow font-semibold">
                                        {{ $barang->stok }}
                                    </span>

                                @else

                                    <span style="background-color: green; color: white;"
                                        class="px-3 py-1 rounded shadow font-semibold">
                                        {{ $barang->stok }}
                                    </span>

                                @endif

                            </td>

                            <td class="p-4 text-center align-middle">
                                {{ $barang->kondisi }}
                            </td>

                            <td class="p-4 text-center align-middle">

                                @if ($barang->stok == 0)

                                    <span style="background-color: red; color: white;"
                                        class="px-3 py-1 rounded shadow">
                                        Tidak Tersedia
                                    </span>

                                @else

                                    <span style="background-color: green; color: white;"
                                        class="px-3 py-1 rounded shadow">
                                        Tersedia
                                    </span>

                                @endif

                            </td>

                            <td class="p-4 text-center align-middle">

                                <a href="{{ route('admin.barang.edit', $barang->id) }}"
                                    style="background-color: black; color: white;"
                                    class="px-3 py-1 rounded shadow">
                                    Edit
                                </a>

                                <form action="{{ route('admin.barang.destroy', $barang->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data barang ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow ml-2">
                                        Hapus
                                    </button>

                                </form>

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

    </div>

    <div class="mt-4">
        {{ $barangs->links() }}
    </div>

@endsection