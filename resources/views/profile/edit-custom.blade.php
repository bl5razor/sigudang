@extends('layouts.dashboard')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Edit Profile
</h2>

<form action="{{ route('profile.update.custom') }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="font-semibold">Nama</label>
        <input type="text"
               name="name"
               value="{{ $user->name }}"
               class="w-full border rounded p-2 mt-1">
    </div>

    <div class="mb-4">
        <label class="font-semibold">Email</label>
        <input type="email"
               name="email"
               value="{{ $user->email }}"
               class="w-full border rounded p-2 mt-1">
    </div>

    <div class="mb-4">
        <label class="font-semibold">Password Baru</label>

        <div class="relative mt-1">
            <input type="password"
                   name="password"
                   id="password"
                   class="w-full border rounded p-2 pr-10">

            <button type="button"
                    onclick="togglePassword('password')"
                    class="absolute right-3 top-2 text-gray-500">
                👁️
            </button>
        </div>
    </div>

    <div class="mb-4">
        <label class="font-semibold">Konfirmasi Password</label>

        <div class="relative mt-1">
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   class="w-full border rounded p-2 pr-10">

            <button type="button"
                    onclick="togglePassword('password_confirmation')"
                    class="absolute right-3 top-2 text-gray-500">
                👁️
            </button>
        </div>
    </div>

    <div class="flex gap-3">

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Simpan
        </button>

        <a href="{{ route('profile.show') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>

    </div>

</form>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);

        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
</script>

@endsection