<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Helpers\ActivityLogger;

class LogSuccessfulLogout
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($event->user) {
            ActivityLogger::log('Logout', 'User logged out: ' . $event->user->name);
        }
    }
    
}
