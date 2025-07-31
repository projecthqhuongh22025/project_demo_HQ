<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserRegistered
{
    use SerializesModels;

    public $user;
    public $activationUrl;

    public function __construct(User $user, string $activationUrl)
    {
        $this->user = $user;
        $this->activationUrl = $activationUrl;
    }
}
