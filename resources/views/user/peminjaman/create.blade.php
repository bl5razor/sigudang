@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Form Peminjaman Barang
</h1>

<div class="bg-white p-6 rounded shadow mb-6">
    <p><b>Barang:</b> {{ $barang->nama_barang }}</p>
    <p><b>Stok tersedia:</b> {{ $barang->stok }}</p>
</div>

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-600 text-white rounded shadow">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('user.peminjaman.store') }}" method="POST">
    @csrf

    <input type="hidden" name="barang_id" value="{{ $barang->id }}">

    <div class="bg-white p-6 rounded shadow">

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Peminjam</label>
            <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam', auth()->user()->name) }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">NIK</label>
            <input type="number" name="nik" value="{{ old('nik') }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Alamat Peminjam</label>
            <textarea name="alamat_peminjam" rows="3"
                class="w-full border rounded p-2">{{ old('alamat_peminjam') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Jumlah Pinjam</label>
            <input type="number" name="jumlah_pinjam" value="{{ old('jumlah_pinjam') }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}"
                min="{{ date('Y-m-d') }}" 
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Durasi Pinjam (Hari)</label>
            <input type="number" name="durasi_pinjam" value="{{ old('durasi_pinjam') }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold">Catatan</label>
            <textarea name="catatan" rows="4"
                class="w-full border rounded p-2">{{ old('catatan') }}</textarea>
        </div>

        <button type="submit"
            style="background-color: black; color: white;"
            class="px-5 py-2 rounded shadow font-semibold">
            Ajukan Peminjaman
        </button>

    </div>
</form>

@endsection