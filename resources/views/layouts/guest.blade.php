<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SI Gudang Desa Daleman</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
<div
    class="min-h-screen flex flex-col sm:justify-center items-center bg-cover bg-center bg-no-repeat"
    style="
        background-image: url('/images/gudang.jpg');
        background-size: cover;
        background-position: center;
        image-rendering: auto;
    ">

    <div class="absolute inset-0 bg-black/25"></div>

        <div class="relative z-10 text-center mb-4">
            <h1 class="text-3xl font-bold text-white">
                SI Gudang Desa Daleman
            </h1>

            <p class="text-gray-200 mt-2">
                Sistem Informasi Pengelolaan Gudang dan Peminjaman Barang
            </p>
        </div>

        <div
            class="relative z-10 w-full sm:max-w-md mt-2 px-6 py-6 bg-white shadow-2xl overflow-hidden rounded-xl">

            <div class="flex justify-center mb-4">
                <x-application-logo class="w-16 h-16 fill-current text-blue-700" />
            </div>

            {{ $slot }}

        </div>

        <div class="relative z-10 mt-4 text-sm text-gray-200">
            © {{ date('Y') }} SI Gudang Desa Daleman
        </div>

    </div>

</body>

</html>