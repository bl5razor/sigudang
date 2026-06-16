<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');

            $table->string('nama_peminjam');
            $table->string('nik', 20);
            $table->text('alamat_peminjam');

            $table->integer('jumlah_pinjam');
            $table->date('tanggal_pinjam');
            $table->integer('durasi_pinjam');
            $table->date('tanggal_kembali');

            $table->text('catatan')->nullable();

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'dipinjam',
                'dikembalikan',
                'terlambat',
                'ditolak'
            ])->default('menunggu');

            $table->integer('denda')->default(0);
            $table->date('tanggal_dikembalikan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};