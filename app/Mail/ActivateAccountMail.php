<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ActivateAccountMail extends Mailable {
    use Queueable, SerializesModels;

    public $user;
    public $activationUrl;

    public function __construct(User $user, string $activationUrl)
    {
        $this->user = $user;
        $this->activationUrl = $activationUrl;
    }

    public function build()
    {
        return $this->subject('Kích hoạt tài khoản')
                    ->markdown('emails.activate')
                    ->with([
                        'user' => $this->user,
                        'url' => $this->activationUrl,
                    ]);
    }
}
