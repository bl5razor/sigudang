<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function create(Barang $barang)
    {
        return view('user.peminjaman.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'nama_peminjam' => 'required',
            'nik' => 'required|digits_between:15,20',
            'alamat_peminjam' => 'required',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'durasi_pinjam' => 'required|integer|min:1',
            'catatan' => 'required', // <-- Ini sudah diubah menjadi required
        ], [
            'nama_peminjam.required' => 'Nama peminjam wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits_between' => 'NIK harus berupa angka 15-20 digit.',
            'alamat_peminjam.required' => 'Alamat wajib diisi.',
            'jumlah_pinjam.required' => 'Jumlah pinjam wajib diisi.',
            'jumlah_pinjam.integer' => 'Jumlah pinjam harus angka.',
            'jumlah_pinjam.min' => 'Jumlah pinjam minimal 1.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'durasi_pinjam.required' => 'Durasi pinjam wajib diisi.',
            'durasi_pinjam.integer' => 'Durasi pinjam harus angka.',
            'durasi_pinjam.min' => 'Durasi pinjam minimal 1 hari.',
            'catatan.required' => 'Catatan wajib diisi.', // <-- Pesan error kustom ditambahkan di sini
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ((int) $request->jumlah_pinjam > $barang->stok) {
            return back()->withErrors([
                'jumlah_pinjam' => 'Jumlah pinjam melebihi stok barang.'
            ])->withInput();
        }

        $tanggalKembali = Carbon::parse($request->tanggal_pinjam)
            ->addDays((int) $request->durasi_pinjam);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'nama_peminjam' => $request->nama_peminjam,
            'nik' => $request->nik,
            'alamat_peminjam' => $request->alamat_peminjam,
            'jumlah_pinjam' => (int) $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'durasi_pinjam' => (int) $request->durasi_pinjam,
            'tanggal_kembali' => $tanggalKembali,
            'catatan' => $request->catatan,
            'status' => 'menunggu',
            'denda' => 0,
            'status_denda' => 'belum_lunas',
        ]);

        return redirect('/user/barang')
            ->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function riwayat(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if (($tanggalAwal && !$tanggalAkhir) || (!$tanggalAwal && $tanggalAkhir)) {
            return back()->withErrors([
                'filter' => 'Tanggal awal dan tanggal akhir harus diisi.'
            ])->withInput();
        }

        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereBetween('tanggal_pinjam', [$tanggalAwal, $tanggalAkhir]);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('user.peminjaman.riwayat', compact(
            'peminjamans',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    public function riwayatDendaUser(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if (($tanggalAwal && !$tanggalAkhir) || (!$tanggalAwal && $tanggalAkhir)) {
            return back()->withErrors([
                'filter' => 'Tanggal awal dan tanggal akhir harus diisi.'
            ])->withInput();
        }

        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->where('denda', '>', 0)
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereBetween('tanggal_dikembalikan', [$tanggalAwal, $tanggalAkhir]);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('user.denda.riwayat', compact(
            'peminjamans',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    public function adminIndex(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if (($tanggalAwal && !$tanggalAkhir) || (!$tanggalAwal && $tanggalAkhir)) {
            return back()->withErrors([
                'filter' => 'Tanggal awal dan tanggal akhir harus diisi.'
            ])->withInput();
        }

        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereBetween('tanggal_pinjam', [$tanggalAwal, $tanggalAkhir]);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.peminjaman.index', compact(
            'peminjamans',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    public function denda()
    {
        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->where('denda', '>', 0)
            ->where('status_denda', 'belum_lunas')
            ->latest()
            ->get();

        return view('admin.denda.index', compact('peminjamans'));
    }

    public function riwayatDenda(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if (($tanggalAwal && !$tanggalAkhir) || (!$tanggalAwal && $tanggalAkhir)) {
            return back()->withErrors([
                'filter' => 'Tanggal awal dan tanggal akhir harus diisi.'
            ])->withInput();
        }

        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->where('denda', '>', 0)
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereBetween('tanggal_dikembalikan', [$tanggalAwal, $tanggalAkhir]);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.denda.riwayat', compact(
            'peminjamans',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    public function verifikasiDenda(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status_denda' => 'lunas',
        ]);

        return redirect()
            ->route('admin.denda')
            ->with('success', 'Denda berhasil diverifikasi.');
    }

    public function laporan(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if (($tanggalAwal && !$tanggalAkhir) || (!$tanggalAwal && $tanggalAkhir)) {
            return back()->withErrors([
                'filter' => 'Tanggal awal dan tanggal akhir harus diisi.'
            ]);
        }

        $peminjamans = $this->getDataLaporan($tanggalAwal, $tanggalAkhir);

        $totalPeminjaman = $peminjamans->count();

        $totalDenda = $peminjamans
            ->where('status_denda', 'belum_lunas')
            ->sum('denda');

        return view('admin.laporan.index', compact(
            'peminjamans',
            'totalPeminjaman',
            'totalDenda',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    public function exportExcel(Request $request)
    {
        $peminjamans = $this->getDataLaporan(
            $request->tanggal_awal,
            $request->tanggal_akhir
        );

        // Menghitung Total Peminjaman
        $totalPeminjaman = $peminjamans->count();

        // Menghitung Total Denda Belum Lunas
        $totalDenda = $peminjamans
            ->where('status_denda', 'belum_lunas')
            ->sum('denda');

        $namaFile = 'laporan-peminjaman.xls';

        // Mengirim data peminjamans, totalPeminjaman, dan totalDenda ke blade
        $html = view('admin.laporan.excel', compact('peminjamans', 'totalPeminjaman', 'totalDenda'))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"');
    }

    public function exportWord(Request $request)
    {
        $peminjamans = $this->getDataLaporan(
            $request->tanggal_awal,
            $request->tanggal_akhir
        );

        // Menghitung Total Peminjaman untuk Word
        $totalPeminjaman = $peminjamans->count();

        // Menghitung Total Denda Belum Lunas untuk Word
        $totalDenda = $peminjamans
            ->where('status_denda', 'belum_lunas')
            ->sum('denda');

        $namaFile = 'laporan-peminjaman.doc';

        // Mengirim data ke blade Word (sudah disiapkan untuk ke depannya)
        $html = view('admin.laporan.word', compact('peminjamans', 'totalPeminjaman', 'totalDenda'))->render();

        return response($html)
            ->header('Content-Type', 'application/msword')
            ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"');
    }

    private function getDataLaporan($tanggalAwal = null, $tanggalAkhir = null)
    {
        return Peminjaman::with(['user', 'barang'])
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereBetween('tanggal_pinjam', [$tanggalAwal, $tanggalAkhir]);
            })
            ->latest()
            ->get();
    }

    public function setujui(Peminjaman $peminjaman)
    {
        $barang = $peminjaman->barang;

        if ($peminjaman->status != 'menunggu') {
            return redirect('/admin/peminjaman')
                ->with('success', 'Peminjaman ini sudah diproses.');
        }

        if ($peminjaman->jumlah_pinjam > $barang->stok) {
            return redirect('/admin/peminjaman')
                ->with('success', 'Stok barang tidak cukup untuk disetujui.');
        }

        $stokBaru = $barang->stok - $peminjaman->jumlah_pinjam;

        $barang->update([
            'stok' => $stokBaru,
            'status' => $stokBaru > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        $peminjaman->update([
            'status' => 'dipinjam',
        ]);

        return redirect('/admin/peminjaman')
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        return redirect('/admin/peminjaman')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        $barang = $peminjaman->barang;

        $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
        $tanggalDikembalikan = Carbon::now()->startOfDay();

        $denda = 0;
        $dendaPerHari = 1000;

        if ($tanggalDikembalikan->greaterThan($tanggalKembali)) {
            $hariTerlambat = (int) $tanggalKembali->diffInDays($tanggalDikembalikan);
            $denda = $hariTerlambat * $dendaPerHari;
        }

        $stokBaru = $barang->stok + $peminjaman->jumlah_pinjam;

        $barang->update([
            'stok' => $stokBaru,
            'status' => $stokBaru > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'denda' => $denda,
            'status_denda' => $denda > 0 ? 'belum_lunas' : 'lunas',
        ]);

        return redirect('/admin/peminjaman')
            ->with('success', 'Barang berhasil dikembalikan. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }
}