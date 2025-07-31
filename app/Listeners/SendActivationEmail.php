<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivateAccountMail;
use Illuminate\Support\Facades\Log;

class SendActivationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserRegistered $event)
    {
        Mail::to($event->user->email)
            ->send(new ActivateAccountMail($event->user, $event->activationUrl));
    }
}
