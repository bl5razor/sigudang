@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">
    Edit User
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

<form action="{{ route('super-admin.users.update', $user->id) }}"
    method="POST">

    @csrf
    @method('PUT')

    <div class="bg-white p-6 rounded shadow">

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Nama
            </label>

            <input type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Email
            </label>

            <input type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Role
            </label>

            <select name="role"
                class="w-full border rounded p-2">

                <option value="user"
                    {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                    User
                </option>

                <option value="admin"
                    {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="super_admin"
                    {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>
                    Super Admin
                </option>

            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Password Baru
            </label>

            <div class="relative">
                <input type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    class="w-full border rounded p-2 pr-10">

                <button type="button"
                    onclick="togglePassword('password')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 mt-1 text-gray-500">
                    👁
                </button>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Kosongkan jika tidak ingin mengubah password.
            </p>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Konfirmasi Password Baru
            </label>

            <div class="relative">
                <input type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="w-full border rounded p-2 pr-10">

                <button type="button"
                    onclick="togglePassword('password_confirmation')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 mt-1 text-gray-500">
                    👁
                </button>
            </div>
        </div>

        <button type="submit"
            style="background-color: black; color: white;"
            class="px-5 py-2 rounded shadow font-semibold">
            Update
        </button>

        <a href="{{ route('super-admin.users') }}"
            class="px-5 py-2 rounded shadow bg-gray-500 text-white ml-2">
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