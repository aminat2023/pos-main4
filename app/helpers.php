<?php

use App\Models\VaultTransaction;
use App\Models\BankTransaction;


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



if (!function_exists('getVaultBalance')) {
    function getVaultBalance(): float
    {
        $totalIn = VaultTransaction::sum('debit');
        $totalOut = VaultTransaction::sum('credit');
        return $totalIn - $totalOut;
    }
}

if (!function_exists('getBankBalance')) {
    function getBankBalance($bankName): float
    {
        $totalIn = BankTransaction::where('bank_name', $bankName)->sum('debit');
        $totalOut = BankTransaction::where('bank_name', $bankName)->sum('credit');
        return $totalIn - $totalOut;
    }
}




