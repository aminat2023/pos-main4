<?php

namespace App\Http\Controllers;

use App\Models\BankTransaction;
use App\Models\MoneyBox;
use App\Models\VaultTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaultTransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:1',
            'bank_name' => 'required|string',
        ]);
    
        $type = $request->type;
        $amount = $request->amount;
        $bank = $request->bank_name;
    
        // Save to VaultTransactions table
        VaultTransaction::create([
            'user_id' => Auth::id(),
            'amount' => $amount,
            'type' => $type,
            'debit' => $type === 'out' ? $amount : null,
            'credit' => $type === 'in' ? $amount : null,
            'bank_name' => $bank,
            'date' => now()->toDateString(),
        ]);
    
        // ✅ Save to BankTransactions table too
        BankTransaction::create([
            'user_id' => Auth::id(),
            'amount' => $amount,
            'debit' => $type === 'in' ? $amount : null,   // bank loses money when vault receives
            'credit' => $type === 'out' ? $amount : null, // bank gains money when vault pays out
            'bank_name' => $bank,
            'payment_method' => 'vault',
            'date' => now()->toDateString(),
        ]);
    
        // Update MoneyBox balances
        $vault = MoneyBox::where('bank_name', 'Vault')->first();
        $selectedBank = MoneyBox::where('bank_name', $bank)->first();
    
        if ($type === 'in') {
            // Bank loses, vault gains
            $vault->balance += $amount;
            $selectedBank->balance -= $amount;
        } elseif ($type === 'out') {
            // Vault loses, bank gains
            $vault->balance -= $amount;
            $selectedBank->balance += $amount;
        }
    
        $vault->save();
        $selectedBank->save();
    
        return redirect()->back()->with('success', 'Vault transaction and bank record saved successfully.');
    }
    
    // Show form to filter vault report
    public function reportForm()
    {
        return view('vault.report');  // resources/views/vault/report.blade.php
    }

    // Process filter and return transactions
    public function reportTable(Request $request)
    {
        $filter = $request->filter_type;
        $from = $request->from_date;
        $to = $request->to_date;
        $month = $request->month;
        $year = $request->year;

        $query = VaultTransaction::query();

        if ($filter === 'date' && $from && $to) {
            $query->whereBetween('date', [$from, $to]);
        } elseif ($filter === 'month' && $month) {
            $parsedMonth = Carbon::parse($month);
            $query
                ->whereMonth('date', $parsedMonth->month)
                ->whereYear('date', $parsedMonth->year);
        } elseif ($filter === 'year' && $year) {
            $query->whereYear('date', $year);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        $noResults = $transactions->isEmpty();

        return view('vault.report_table', compact('transactions', 'noResults'));
    }

    // Show Vault IN form
    public function showVaultInForm()
    {
        return view('vault.in');  // resources/views/vault/in.blade.php
    }

    // Show Vault OUT form
    public function showVaultOutForm()
    {
        return view('vault.out');  // resources/views/vault/out.blade.php
    }

    // Store vault transaction
}
