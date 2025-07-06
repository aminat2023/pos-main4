<?php


if (!function_exists('getPreference')) {
    function getPreference($key, $default = null)
    {
        $row = \App\Models\SystemPreference::where('key', $key)->first();

        if (!$row) {
            return $default;
        }

        $value = $row->value;

        // Decode only if it's a JSON string
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $value;
    }
}



