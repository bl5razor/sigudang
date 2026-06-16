<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Models\User;
use App\Models\Barang;
use App\Models\Peminjaman;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/test-email', function () {
    Mail::to('faiqfajar46@gmail.com')
        ->send(new TestEmail());

    return 'Email berhasil dikirim!';
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');

Route::get('/dashboard', function () {

    $role = Auth::user()->role;

    if ($role === 'admin') {
        return view('dashboard.admin');
    }

    if ($role === 'super_admin') {

        $totalUser = User::where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalSuperAdmin = User::where('role', 'super_admin')->count();
        $totalAkun = User::count();

        $aktivitasTerbaru = Peminjaman::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.super-admin', compact(
            'totalUser',
            'totalAdmin',
            'totalSuperAdmin',
            'totalAkun',
            'aktivitasTerbaru'
        ));
    }

    $totalBarangTersedia = Barang::where('stok', '>', 0)->count();

    $totalPeminjamanSaya = Peminjaman::where('user_id', Auth::id())
        ->count();

    $sedangDipinjam = Peminjaman::where('user_id', Auth::id())
        ->where('status', 'dipinjam')
        ->count();

    $totalDendaSaya = Peminjaman::where('user_id', Auth::id())
        ->where('status_denda', 'belum_lunas')
        ->sum('denda');

    $riwayatTerbaru = Peminjaman::with('barang')
        ->where('user_id', Auth::id())
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard.user', compact(
        'totalBarangTersedia',
        'totalPeminjamanSaya',
        'sedangDipinjam',
        'totalDendaSaya',
        'riwayatTerbaru'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin-test', function () {
    return 'Halaman Admin';
})->middleware(['auth', 'role:admin']);

Route::get('/super-admin-test', function () {
    return 'Halaman Super Admin';
})->middleware(['auth', 'role:super_admin']);

Route::get('/user-test', function () {
    return 'Halaman User';
})->middleware(['auth', 'role:user']);

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/barang', [BarangController::class, 'index'])
        ->name('admin.barang');

    Route::get('/admin/barang/create', [BarangController::class, 'create'])
        ->name('admin.barang.create');

    Route::post('/admin/barang', [BarangController::class, 'store'])
        ->name('admin.barang.store');

    Route::get('/admin/barang/{barang}/edit', [BarangController::class, 'edit'])
        ->name('admin.barang.edit');

    Route::put('/admin/barang/{barang}', [BarangController::class, 'update'])
        ->name('admin.barang.update');

    Route::delete('/admin/barang/{barang}', [BarangController::class, 'destroy'])
        ->name('admin.barang.destroy');

    Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])
        ->name('admin.peminjaman');

    Route::get('/admin/denda', [PeminjamanController::class, 'denda'])
        ->name('admin.denda');

    Route::get('/admin/denda/riwayat', [PeminjamanController::class, 'riwayatDenda'])
        ->name('admin.denda.riwayat');

    Route::put('/admin/denda/{peminjaman}/verifikasi', [PeminjamanController::class, 'verifikasiDenda'])
        ->name('admin.denda.verifikasi');

    Route::put('/admin/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
        ->name('admin.peminjaman.setujui');

    Route::put('/admin/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])
        ->name('admin.peminjaman.tolak');

    Route::put('/admin/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('admin.peminjaman.kembalikan');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/super-admin/users', [UserController::class, 'index'])
        ->name('super-admin.users');

    Route::get('/super-admin/users/create', [UserController::class, 'create'])
        ->name('super-admin.users.create');

    Route::post('/super-admin/users', [UserController::class, 'store'])
        ->name('super-admin.users.store');

    Route::get('/super-admin/users/{user}/edit', [UserController::class, 'edit'])
        ->name('super-admin.users.edit');

    Route::put('/super-admin/users/{user}', [UserController::class, 'update'])
        ->name('super-admin.users.update');

    Route::delete('/super-admin/users/{user}', [UserController::class, 'destroy'])
        ->name('super-admin.users.destroy');

    Route::get('/super-admin/laporan', [PeminjamanController::class, 'laporan'])
        ->name('super-admin.laporan');

    Route::get('/super-admin/laporan/excel', [PeminjamanController::class, 'exportExcel'])
        ->name('super-admin.laporan.excel');

    Route::get('/super-admin/laporan/word', [PeminjamanController::class, 'exportWord'])
        ->name('super-admin.laporan.word');
});

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/barang', [BarangController::class, 'userIndex'])
        ->name('user.barang');

    Route::get('/user/barang/{barang}/pinjam', [PeminjamanController::class, 'create'])
        ->name('user.peminjaman.create');

    Route::post('/user/peminjaman', [PeminjamanController::class, 'store'])
        ->name('user.peminjaman.store');

    Route::get('/user/peminjaman/riwayat', [PeminjamanController::class, 'riwayat'])
        ->name('user.peminjaman.riwayat');

    Route::get('/user/denda/riwayat', [PeminjamanController::class, 'riwayatDendaUser'])
        ->name('user.denda.riwayat');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile-saya', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/profile-saya/edit', [ProfileController::class, 'editProfile'])
        ->name('profile.edit.custom');

    Route::put('/profile-saya/update', [ProfileController::class, 'updateProfile'])
        ->name('profile.update.custom');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';