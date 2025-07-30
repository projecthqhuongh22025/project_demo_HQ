<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivateAccountMail extends Mailable {
    use Queueable, SerializesModels;

    public $activationUrl;

    public function __construct($activationUrl) {
        $this->activationUrl = $activationUrl;
    }

    public function build() {
        return $this->subject('Kích hoạt tài khoản')
                    ->view('emails.activate');
    }
}
