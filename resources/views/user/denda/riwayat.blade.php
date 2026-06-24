@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-2 text-gray-800">
    Riwayat Denda Saya
</h1>

<p class="text-gray-500 mb-6">
    Rekap data denda peminjaman barang
</p>

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

    <form action="{{ route('user.denda.riwayat') }}"
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

        <a href="{{ route('user.denda.riwayat') }}"
            style="background-color: gray; color: white;"
            class="h-[42px] px-6 rounded-lg shadow font-semibold flex items-center justify-center">
            Reset
        </a>

    </form>

</div>

<div class="bg-white rounded-xl shadow border overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full min-w-[1000px]">

            <thead>

                <tr class="bg-gray-300 text-gray-800">

                    <th class="p-4 text-center">
                        No
                    </th>

                    <th class="p-4 text-center">
                        Barang
                    </th>

                    <th class="p-4 text-center">
                        Tanggal Dikembalikan
                    </th>

                    <th class="p-4 text-center">
                        Denda
                    </th>

                    <th class="p-4 text-center">
                        Status Denda
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse ($peminjamans as $peminjaman)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-4 text-center">
                            {{ $peminjamans->firstItem() + $loop->index }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->barang->nama_barang ?? '-' }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $peminjaman->tanggal_dikembalikan }}
                        </td>

                        <td class="p-4 text-center">
                            Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-center">

                            @if($peminjaman->status_denda == 'lunas')

                                <span
                                    style="background-color: green; color: white;"
                                    class="px-3 py-1 rounded shadow">
                                    Lunas
                                </span>

                            @else

                                <span
                                    style="background-color: red; color: white;"
                                    class="px-3 py-1 rounded shadow">
                                    Belum Lunas
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="p-6 text-center text-gray-500">
                            Belum ada riwayat denda.
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