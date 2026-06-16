<?php

namespace App\Console\Commands;

use App\Mail\ReminderPengembalianMail;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimReminderPengembalian extends Command
{
    protected $signature = 'app:kirim-reminder-pengembalian';

    protected $description = 'Mengirim email reminder H-1 pengembalian barang';

    public function handle()
    {
        $besok = Carbon::tomorrow()->toDateString();

        $peminjamanList = Peminjaman::with(['user', 'barang'])
            ->where('tanggal_kembali', $besok)
            ->where('status', 'dipinjam')
            ->where('reminder_terkirim', false)
            ->get();

        foreach ($peminjamanList as $peminjaman) {

            if ($peminjaman->user && $peminjaman->user->email) {

                Mail::to($peminjaman->user->email)
                    ->send(new ReminderPengembalianMail($peminjaman));

                $peminjaman->update([
                    'reminder_terkirim' => true,
                ]);

                $this->info('Reminder terkirim ke: ' . $peminjaman->user->email);
            }
        }

        $this->info('Selesai mengirim reminder.');
    }
}