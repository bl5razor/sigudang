@extends('layouts.dashboard')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Profile Saya
</h2>

<div class="space-y-4">

    <div>
        <label class="font-semibold">Nama</label>
        <input type="text"
               value="{{ $user->name }}"
               readonly
               class="w-full border rounded p-2 bg-gray-100">
    </div>

    <div>
        <label class="font-semibold">Email</label>
        <input type="text"
               value="{{ $user->email }}"
               readonly
               class="w-full border rounded p-2 bg-gray-100">
    </div>

    <div>
        <label class="font-semibold">Password</label>
        <input type="text"
               value="********"
               readonly
               class="w-full border rounded p-2 bg-gray-100">
    </div>

    <div class="flex gap-3">

        <a href="{{ route('profile.edit.custom') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Edit Profile
        </a>

        <button onclick="history.back()"
                class="bg-gray-500 text-white px-4 py-2 rounded">
            Kembali
        </button>

    </div>

</div>

@endsection