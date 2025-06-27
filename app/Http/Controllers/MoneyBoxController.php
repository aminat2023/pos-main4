<?php

namespace App\Http\Controllers;

use App\Models\VaultTransaction;
use App\Models\BankTransaction;
use App\Models\MoneyBox;

class MoneyBoxController extends Controller
{
    public function index()
    {
        // Get banks from preferences
        $banks = getPreference('banks', []);
        if (!is_array($banks)) $banks = [];

        // Calculate vault balance
        $vaultDebit = VaultTransaction::sum('debit');
        $vaultCredit = VaultTransaction::sum('credit');
        $vaultBalance = $vaultCredit - $vaultDebit;

        // 💾 Save vault balance in money_boxes table under "Vault"
        MoneyBox::updateOrCreate(
            ['bank_name' => 'Vault'],
            ['balance' => $vaultBalance]
        );

        // Calculate balances for each bank
        $bankBalances = [];
        foreach ($banks as $bank) {
            $debit = BankTransaction::where('bank_name', $bank)->sum('debit');
            $credit = BankTransaction::where('bank_name', $bank)->sum('credit');
            $balance = $credit - $debit;

            // Save to array for view
            $bankBalances[$bank] = $balance;

            // 💾 Update or create record in money_boxes table
            MoneyBox::updateOrCreate(
                ['bank_name' => $bank],
                ['balance' => $balance]
            );
        }

        return view('moneybox.index', compact('vaultBalance', 'bankBalances'));
    }
}
