@extends('layouts.dashboard')

@section('content')

    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            nav,
            aside,
            .no-print {
                display: none !important;
            }

            main {
                padding: 0 !important;
            }

            body {
                background: white !important;
                zoom: 80%;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* --- FIX UNTUK KOTAK TOTAL --- */
            .print-totals {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                gap: 20px !important;
                margin-bottom: 20px !important;
                page-break-inside: avoid !important;
            }

            .print-box {
                flex: 1 !important;
                border: 2px solid #9ca3af !important; /* Garis tepi kotak saat di-print */
                padding: 15px !important;
                border-radius: 8px !important;
                box-shadow: none !important;
            }

            .print-box h2 {
                font-size: 14px !important;
                color: #374151 !important;
                margin: 0 !important;
            }

            .print-box p {
                font-size: 28px !important;
                font-weight: bold !important;
                margin-top: 8px !important;
            }
            
            .text-blue-600 { color: #2563eb !important; }
            .text-red-600 { color: #dc2626 !important; }
            /* ----------------------------- */

            .overflow-x-auto {
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                min-width: 100% !important;
                font-size: 9px !important;
                table-layout: auto;
                border-collapse: collapse !important;
            }

            th, td {
                padding: 4px !important;
                word-break: break-word;
                border: 1px solid #d1d5db !important; /* Tambahan garis tabel */
            }

            .print-badge {
                background-color: transparent !important;
                color: black !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>

    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4 mb-6 no-print">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Laporan Peminjaman Si Gudang
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Rekap data peminjaman dan denda
            </p>
        </div>

        <div class="flex flex-col lg:items-end">
            <div class="flex flex-wrap gap-3 lg:justify-end">

                <button onclick="window.print()"
                    class="px-5 py-3 rounded-lg shadow font-semibold text-white bg-blue-600 hover:bg-blue-700 transition">
                    Cetak PDF
                </button>

                <a href="{{ route('super-admin.laporan.excel', request()->query()) }}"
                    class="px-5 py-3 rounded-lg shadow font-semibold text-white bg-green-600 hover:bg-green-700 transition">
                    Download Excel
                </a>

                <a href="{{ route('super-admin.laporan.word', request()->query()) }}"
                    class="px-5 py-3 rounded-lg shadow font-semibold text-white bg-orange-500 hover:bg-orange-600 transition">
                    Download Word
                </a>

            </div>
            <p class="text-xs text-gray-500 mt-2 text-right lg:max-w-md">
                *Pastikan mengatur Layout ke <b>Landscape</b> dan mematikan <b>Headers and footers</b> pada dialog print browser.
            </p>
        </div>

    </div>

    @if ($errors->has('filter'))
        <div class="mb-4 p-4 rounded shadow no-print" style="background-color: red; color: white;">
            {{ $errors->first('filter') }}
        </div>
    @endif

    <div class="bg-white p-5 rounded-xl shadow mb-6 no-print">

        <form action="{{ route('super-admin.laporan') }}" method="GET"
            class="flex flex-col md:flex-row gap-4 md:items-end">

            <div>
                <label class="block mb-2 font-semibold">
                    Tanggal Awal
                </label>

                <input type="date" name="tanggal_awal" value="{{ $tanggalAwal ?? '' }}"
                    class="border rounded-lg px-4 py-2 w-full">
            </div>

            <div>
                <label class="block mb-2 font-semibold">
                    Tanggal Akhir
                </label>

                <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir ?? '' }}"
                    class="border rounded-lg px-4 py-2 w-full">
            </div>

            <button type="submit"
                class="h-[42px] px-5 rounded-lg shadow font-semibold flex items-center justify-center text-white bg-green-600 hover:bg-green-700">
                Filter
            </button>

            <a href="{{ route('super-admin.laporan') }}"
                class="h-[42px] px-5 rounded-lg shadow font-semibold flex items-center justify-center text-white bg-gray-500 hover:bg-gray-600">
                Reset
            </a>

        </form>

    </div>

    <div class="print-area">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Laporan Peminjaman Barang
        </h1>

        @if (!empty($tanggalAwal) && !empty($tanggalAkhir))
            <p class="mb-4 text-gray-700">
                Periode:
                <strong>{{ $tanggalAwal }}</strong>
                sampai
                <strong>{{ $tanggalAkhir }}</strong>
            </p>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 print-totals">

            <div class="bg-white p-6 rounded-xl shadow print-box">

                <h2 class="text-gray-600 font-semibold">
                    Total Peminjaman
                </h2>

                <p class="text-4xl font-bold mt-3 text-blue-600">
                    {{ $totalPeminjaman }}
                </p>

            </div>

            <div class="bg-white p-6 rounded-xl shadow print-box">

                <h2 class="text-gray-600 font-semibold">
                    Total Denda Belum Lunas
                </h2>

                <p class="text-4xl font-bold mt-3 text-red-600">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </p>

            </div>

        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full border border-gray-300">

                    <thead>

                        <tr class="bg-gray-300 text-gray-800">

                            <th class="p-3 text-center border">No</th>
                            <th class="p-3 text-center border">Nama Peminjam</th>
                            <th class="p-3 text-center border">NIK</th>
                            <th class="p-3 text-center border">Alamat Peminjam</th>
                            <th class="p-3 text-center border">Barang</th>
                            <th class="p-3 text-center border">Jumlah</th>
                            <th class="p-3 text-center border">Catatan</th>
                            <th class="p-3 text-center border">Tanggal Pinjam</th>
                            <th class="p-3 text-center border">Tanggal Kembali</th>
                            <th class="p-3 text-center border">Status</th>
                            <th class="p-3 text-center border">Denda</th>
                            <th class="p-3 text-center border">Status Denda</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($peminjamans as $peminjaman)
                            <tr class="border-b hover:bg-gray-50">

                                <td class="p-3 text-center border">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->nama_peminjam }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->nik }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->alamat_peminjam }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->barang->nama_barang ?? '-' }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->jumlah_pinjam }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->catatan ?? '-' }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->tanggal_pinjam }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ $peminjaman->tanggal_kembali }}
                                </td>

                                <td class="p-3 text-center border">
                                    {{ ucfirst($peminjaman->status) }}
                                </td>

                                <td class="p-3 text-center border">
                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                </td>

                                <td class="p-3 text-center border">

                                    @if ($peminjaman->denda > 0)
                                        @if ($peminjaman->status_denda == 'lunas')
                                            <span
                                                class="px-4 py-2 rounded-lg shadow inline-block bg-green-600 text-white print-badge">
                                                Lunas
                                            </span>
                                        @else
                                            <span
                                                class="px-4 py-2 rounded-lg shadow inline-block bg-red-600 text-white print-badge">
                                                Belum Lunas
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="px-4 py-2 rounded-lg shadow inline-block bg-gray-500 text-white print-badge">
                                            Tidak Ada Denda
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="12" class="p-6 text-center text-gray-500 border">
                                    Belum ada data laporan
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection