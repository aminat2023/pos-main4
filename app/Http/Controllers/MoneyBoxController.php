<?php

namespace App\Http\Controllers;

use App\Models\VaultTransaction;
use App\Models\BankTransaction;

class MoneyBoxController extends Controller
{
    public function index()
    {
        // Get banks from preferences
        $banks = getPreference('banks', []);
        if (!is_array($banks)) $banks = [];

        // ✅ Dynamically calculate vault balance
        $vaultDebit = VaultTransaction::sum('debit');
        $vaultCredit = VaultTransaction::sum('credit');
        $vaultBalance = $vaultCredit - $vaultDebit;

        // ✅ Dynamically calculate bank balances
        $bankBalances = [];
        foreach ($banks as $bank) {
            $debit = BankTransaction::where('bank_name', $bank)->sum('debit');
            $credit = BankTransaction::where('bank_name', $bank)->sum('credit');
            $balance = $credit - $debit;

            $bankBalances[$bank] = $balance;
        }

        return view('moneybox.index', compact('vaultBalance', 'bankBalances'));
    }
}
