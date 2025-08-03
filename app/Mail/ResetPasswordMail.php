<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPasswordMail extends Mailable {
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
        return $this->subject('Đặt lại mật khẩu')
                    ->markdown('emails.resetpassword')
                    ->with([
                        'user' => $this->user,
                        'url' => $this->activationUrl,
                    ]);
    }
}
