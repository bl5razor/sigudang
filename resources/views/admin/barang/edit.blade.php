@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Edit Barang
</h1>

@if ($errors->any())

    <div class="mb-4 p-4 bg-red-600 text-white rounded shadow">

        <ul class="list-disc pl-5">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form action="{{ route('admin.barang.update', $barang->id) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="bg-white p-6 rounded shadow">

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Nama Barang
            </label>

            <input type="text"
                name="nama_barang"
                value="{{ $barang->nama_barang }}"
                class="w-full border rounded p-2"
                required>

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Kategori
            </label>

            <input type="text"
                name="kategori"
                value="{{ $barang->kategori }}"
                class="w-full border rounded p-2"
                required>

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Stok
            </label>

            <input type="number"
                name="stok"
                value="{{ $barang->stok }}"
                class="w-full border rounded p-2"
                required>

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Kondisi
            </label>

            <select name="kondisi"
                class="w-full border rounded p-2">

                <option value="baik"
                    {{ $barang->kondisi == 'baik' ? 'selected' : '' }}>
                    Baik
                </option>

                <option value="rusak ringan"
                    {{ $barang->kondisi == 'rusak ringan' ? 'selected' : '' }}>
                    Rusak Ringan
                </option>

                <option value="rusak berat"
                    {{ $barang->kondisi == 'rusak berat' ? 'selected' : '' }}>
                    Rusak Berat
                </option>

            </select>

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Foto Saat Ini
            </label>

            @if ($barang->foto)

                <img src="{{ asset('storage/' . $barang->foto) }}"
                    class="w-32 rounded shadow mb-3">

            @else

                <p>Tidak ada foto</p>

            @endif

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Ganti Foto Barang
            </label>

            <input type="file"
                name="foto"
                class="w-full border rounded p-2"
                accept="image/jpeg,image/png,image/webp">

            <p class="text-sm text-gray-500 mt-1">
                Format foto: JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
            </p>

        </div>

        <div class="mb-6">

            <label class="block mb-2 font-semibold">
                Deskripsi
            </label>

            <textarea name="deskripsi"
                rows="4"
                class="w-full border rounded p-2">{{ $barang->deskripsi }}</textarea>

        </div>

        <button type="submit"
            style="background-color: black; color: white;"
            class="px-5 py-2 rounded shadow font-semibold hover:opacity-90 transition duration-200">

            Update

        </button>

    </div>

</form>

@endsection