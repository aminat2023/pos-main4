<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('getPreference')) {
    function getPreference($key, $default = null)
    {
        // Optional: Filter by user_id if each user has separate settings
        // Assuming single set of preferences for now
        $preference = DB::table('system_preferences')->where('key', $key)->value('value');

        return $preference ?? $default;
    }
}

if (!function_exists('getAllPreferences')) {
    function getAllPreferences()
    {
        // Fetch preferences as key => value array
        return DB::table('system_preferences')->pluck('value', 'key')->toArray();
    }
}
