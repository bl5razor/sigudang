<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {

            $table->id();

            // nama barang
            $table->string('nama_barang');

            // kategori barang
            $table->string('kategori');

            // jumlah stok barang
            $table->integer('stok');

            // kondisi barang
            $table->enum('kondisi', [
                'baik',
                'rusak ringan',
                'rusak berat'
            ])->default('baik');

            // status barang
            $table->enum('status', [
                'tersedia',
                'dipinjam'
            ])->default('tersedia');

            // deskripsi barang
            $table->text('deskripsi')->nullable();

            // foto barang
            $table->string('foto')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};