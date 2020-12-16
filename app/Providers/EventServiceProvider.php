<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\UserLoginedListener;
use Illuminate\Support\Facades\Log;
use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    public function shouldDiscoverEvents()
    {
        return true;
    }

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        '\App\Events\onUserBootEvent' => [
            'App\Listeners\UserBootListener@handle'
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UserLoginedListener@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Event::listen('Illuminate\Auth\Events\Logout', function () {
            Log::info('Logout detected');
        });

        /*Event::listen('Illuminate\Auth\Events\*', function () {
            Log::info('* detected');
        });*/
    }
}
