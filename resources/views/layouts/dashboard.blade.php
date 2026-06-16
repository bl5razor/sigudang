<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SI Gudang Desa Daleman</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Overlay Mobile -->
        <div id="overlay"
            onclick="closeSidebar()"
            class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden">
        </div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:sticky top-0 left-0 min-h-screen w-64 flex-shrink-0
                   bg-slate-800 text-gray-300 flex flex-col shadow-xl z-50
                   transform -translate-x-full lg:translate-x-0
                   transition-transform duration-300">

            <!-- Logo -->
            <div class="bg-blue-600 px-4 py-5 flex items-center justify-center shadow-md">

                <h1 class="text-white font-bold text-lg text-center">
                    SI Gudang Desa Daleman
                </h1>

            </div>

            <!-- Profile -->
            <a href="{{ route('profile.show') }}"
                class="p-5 flex items-center gap-3 border-b border-slate-700 hover:bg-slate-700 transition">

                <div class="w-10 h-10 rounded-full bg-slate-600 flex items-center justify-center">
                    👤
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">
                        {{ auth()->user()->name ?? 'admin' }}
                    </p>

                    <p class="text-xs text-gray-400 capitalize">
                        {{ auth()->user()->role ?? 'admin' }}
                    </p>
                </div>

            </a>

            <!-- Menu -->
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

                <a href="/dashboard"
                    class="block px-3 py-2 rounded-lg transition
                    {{ request()->is('dashboard')
                        ? 'bg-blue-500 text-white'
                        : 'hover:bg-slate-700 hover:text-white' }}">
                    Dashboard
                </a>

                @if(auth()->user()->role === 'admin')

                    <div class="pt-4 pb-1">
                        <p class="text-xs uppercase text-gray-500 px-3">
                            Admin Functions
                        </p>
                    </div>

                    <a href="{{ route('admin.barang') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.barang')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Daftar Barang
                    </a>

                    <a href="{{ route('admin.peminjaman') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.peminjaman')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Data Peminjaman
                    </a>

                    <a href="{{ route('admin.denda') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.denda')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Verifikasi Denda
                    </a>

                    <a href="{{ route('admin.denda.riwayat') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.denda.riwayat')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Riwayat Denda
                    </a>

                @endif

                @if(auth()->user()->role === 'super_admin')

                    <div class="pt-4 pb-1">
                        <p class="text-xs uppercase text-gray-500 px-3">
                            Super Admin Tools
                        </p>
                    </div>

                    <a href="{{ route('super-admin.users') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('super-admin.users')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Kelola User
                    </a>

                    <a href="{{ route('super-admin.laporan') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('super-admin.laporan')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Laporan
                    </a>

                @endif

                @if(auth()->user()->role === 'user')

                    <div class="pt-4 pb-1">
                        <p class="text-xs uppercase text-gray-500 px-3">
                            User Portal
                        </p>
                    </div>

                    <a href="{{ route('user.barang') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('user.barang')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Daftar Barang
                    </a>

                    <a href="{{ route('user.peminjaman.riwayat') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('user.peminjaman.riwayat')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Riwayat Peminjaman
                    </a>

                    <a href="{{ route('user.denda.riwayat') }}"
                        class="block px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('user.denda.riwayat')
                            ? 'bg-blue-500 text-white'
                            : 'hover:bg-slate-700 hover:text-white' }}">
                        Riwayat Denda
                    </a>

                @endif

            </div>

            <!-- Logout -->
            <div class="p-4 border-t border-slate-700">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                        Logout
                    </button>

                </form>

            </div>

        </aside>

        <!-- Content -->
        <main class="flex-1 min-w-0 overflow-x-auto">

            <!-- Navbar Mobile -->
            <div class="lg:hidden bg-white shadow px-4 py-3 flex items-center">

                <button onclick="openSidebar()"
                    class="text-2xl font-bold text-gray-700">
                    ☰
                </button>

                <span class="ml-4 font-semibold text-gray-800">
                    SI Gudang Desa Daleman
                </span>

            </div>

            <!-- Content Area -->
            <div class="p-4 md:p-8">

                <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-gray-200 overflow-x-auto">

                    @yield('content')

                </div>

            </div>

        </main>

    </div>

    <script>

        function openSidebar() {

            document
                .getElementById('sidebar')
                .classList
                .remove('-translate-x-full');

            document
                .getElementById('overlay')
                .classList
                .remove('hidden');
        }

        function closeSidebar() {

            document
                .getElementById('sidebar')
                .classList
                .add('-translate-x-full');

            document
                .getElementById('overlay')
                .classList
                .add('hidden');
        }

    </script>

</body>

</html>