<?php

namespace App\Listeners;

use App\Events\onUserBootEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\User;
class UserBootListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  onUserBootEvent  $event
     * @return void
     */
    public function handle(onUserBootEvent $event)
    {
        Log::info('UserBootListener worked');
    }
}
