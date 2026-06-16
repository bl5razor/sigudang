<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {

            $table->boolean('reminder_terkirim')
                ->default(false)
                ->after('tanggal_dikembalikan');

        });
    }

    public function down(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {

            $table->dropColumn('reminder_terkirim');

        });
    }
};