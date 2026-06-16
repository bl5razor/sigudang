@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Tambah Barang
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

<form action="{{ route('admin.barang.store') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <div class="bg-white p-6 rounded shadow">

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Nama Barang
            </label>

            <input type="text"
                name="nama_barang"
                value="{{ old('nama_barang') }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Kategori
            </label>

            <input type="text"
                name="kategori"
                value="{{ old('kategori') }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Stok
            </label>

            <input type="number"
                name="stok"
                value="{{ old('stok') }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Kondisi
            </label>

            <select name="kondisi"
                class="w-full border rounded p-2">

                <option value="baik">Baik</option>
                <option value="rusak ringan">Rusak Ringan</option>
                <option value="rusak berat">Rusak Berat</option>

            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Foto Barang
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
                class="w-full border rounded p-2">{{ old('deskripsi') }}</textarea>
        </div>

        <button type="submit"
            style="background-color: black; color: white;"
            class="px-5 py-2 rounded shadow font-semibold hover:opacity-90 transition duration-200">

            Simpan

        </button>

    </div>

</form>

@endsection