@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">
    Kelola User
</h1>

@if (session('success'))
    <div style="background-color: green; color: white;"
        class="mb-4 p-4 rounded shadow font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">

    <a href="{{ route('super-admin.users.create') }}"
        class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded shadow font-semibold">
        + Tambah User
    </a>

</div>

<!-- RESPONSIVE TABLE -->
<div class="bg-white rounded-lg shadow overflow-x-auto">

    <table class="w-full min-w-[800px]">

        <thead>
            <tr class="bg-gray-300 text-gray-800">

                <th class="p-4 text-center">
                    No
                </th>

                <th class="p-4 text-center">
                    Nama
                </th>

                <th class="p-4 text-center">
                    Email
                </th>

                <th class="p-4 text-center">
                    Role
                </th>

                <th class="p-4 text-center">
                    Aksi
                </th>

            </tr>
        </thead>

        <tbody>

            @forelse ($users as $user)

                <tr class="border-b hover:bg-gray-100">

                    <td class="p-4 text-center">
                        {{ $users->firstItem() + $loop->index }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $user->name }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $user->email }}
                    </td>

                    <td class="p-4 text-center">

                        @if ($user->role == 'super_admin')

                            <span style="background-color: red; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Super Admin
                            </span>

                        @elseif ($user->role == 'admin')

                            <span style="background-color: green; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Admin
                            </span>

                        @else

                            <span style="background-color: royalblue; color: white;"
                                class="px-3 py-1 rounded shadow">
                                User
                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex justify-center items-center gap-2">

                            <a href="{{ route('super-admin.users.edit', $user->id) }}"
                                style="background-color: black; color: white;"
                                class="px-3 py-1 rounded shadow">
                                Edit
                            </a>

                            @if ($user->id != auth()->id())

                                <form action="{{ route('super-admin.users.destroy', $user->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded shadow">
                                        Hapus
                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="p-6 text-center text-gray-500">

                        Belum ada data user

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection