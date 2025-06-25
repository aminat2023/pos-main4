<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Helpers\ActivityLogger;

class LogSuccessfulLogin
{
    /**
     * Handle the login event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        ActivityLogger::log('Login', 'User logged in: ' . $event->user->name);
    }
}
