<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterEmailPejabatPengadaan extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $send;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($send)
    {
        $this->send = $send;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply.vms@unesa.ac.id')
            ->view('emails/mail-pejabat-pengadaan')
            ->with(
                [
                    'website' => request()->getSchemeAndHttpHost() . '/aktivasi-pejabat-pengadaan',
                    // 'http://localhost:8002/aktivasi',
                ]
            );
    }
}
