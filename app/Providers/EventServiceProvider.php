<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\UserRegistered;
use App\Listeners\SendActivationEmail;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
