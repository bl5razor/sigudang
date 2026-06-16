@extends('layouts.dashboard')

@section('content')

@php
    $totalBarang = \App\Models\Barang::count();
    $totalStok = \App\Models\Barang::sum('stok');

    $totalPeminjaman = \App\Models\Peminjaman::count();
    $barangDipinjam = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
    $peminjamanMenunggu = \App\Models\Peminjaman::where('status', 'menunggu')->count();
    $peminjamanDitolak = \App\Models\Peminjaman::where('status', 'ditolak')->count();

    $totalDenda = \App\Models\Peminjaman::where('status_denda', 'belum_lunas')
        ->sum('denda');
@endphp

<h1 class="text-3xl font-bold mb-2 text-gray-800">
    Dashboard Admin
</h1>

<p class="mb-6 text-gray-600">
    Selamat datang di Sistem Informasi Gudang Desa Daleman.
</p>

<div style="display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">

    <div style="background-color: royalblue; color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 200px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Total Barang</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalBarang }}
        </p>
    </div>

    <div style="background-color: green; color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 200px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Total Peminjaman</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $totalPeminjaman }}
        </p>
    </div>

    <div style="background-color: orange; color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 200px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Menunggu</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $peminjamanMenunggu }}
        </p>
    </div>

    <div style="background-color: red; color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 200px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="font-weight: 600;">Ditolak</h2>
        <p style="font-size: 36px; font-weight: bold; margin-top: 12px;">
            {{ $peminjamanDitolak }}
        </p>
    </div>

</div>

<div style="display: flex; gap: 20px; flex-wrap: wrap;">

    <div style="background-color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 250px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="color: #4b5563; font-weight: 600;">
            Barang Sedang Dipinjam
        </h2>

        <p style="font-size: 36px; font-weight: bold; margin-top: 12px; color: green;">
            {{ $barangDipinjam }}
        </p>
    </div>

    <div style="background-color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 250px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="color: #4b5563; font-weight: 600;">
            Stok Tersedia
        </h2>

        <p style="font-size: 36px; font-weight: bold; margin-top: 12px; color: blue;">
            {{ $totalStok }}
        </p>
    </div>

    <div style="background-color: white; padding: 24px; border-radius: 10px; flex: 1; min-width: 250px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <h2 style="color: #4b5563; font-weight: 600;">
            Total Denda Belum Lunas
        </h2>

        <p style="font-size: 30px; font-weight: bold; margin-top: 12px; color: red;">
            Rp {{ number_format($totalDenda, 0, ',', '.') }}
        </p>
    </div>

</div>

@endsection