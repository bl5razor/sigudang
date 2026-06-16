<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
    'user_id',
    'barang_id',
    'nama_peminjam',
    'nik',
    'alamat_peminjam',
    'jumlah_pinjam',
    'tanggal_pinjam',
    'durasi_pinjam',
    'tanggal_kembali',
    'catatan',
    'status',
    'denda',
    'status_denda',
    'tanggal_dikembalikan',
    'reminder_terkirim',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}