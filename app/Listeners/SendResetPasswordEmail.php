<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use App\Events\ForgotPasswordEvent;
use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ForgotPassword $event): void
    {
        Mail::to($event->user->email)
            ->send(new ResetPasswordMail($event->user, $event->activationUrl));
    }
}
