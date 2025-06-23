<?php
namespace App\Helpers;

use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($activity, $description = null)
    {
        UserActivityLog::create([
            'user_id'    => Auth::id(),
            'activity'   => $activity,
            'description'=> $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
