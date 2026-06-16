<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this
            ->subject('Test Email SI Gudang')
            ->html('
                <h2>Email Berhasil Dikirim 🎉</h2>
                <p>Konfigurasi Gmail SMTP Laravel sudah berhasil.</p>
            ');
    }
}