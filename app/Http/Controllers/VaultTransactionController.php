<?php

namespace App\Http\Controllers;

use App\Models\VaultTransaction;
use App\Models\BankTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaultTransactionController extends Controller
{
    public function showVaultInForm()
    {
        return view('vault.vault_in');
    }

    public function showVaultOutForm()
    {
        return view('vault.vault_out');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'type' => 'required|in:in,out',
    //         'amount' => 'required|numeric|min:1',
    //         'reason' => 'nullable|string|max:255',
    //         'bank_name' => $request->type === 'out' ? 'required|string|max:255' : 'nullable',
    //     ]);

    //     // Store in VaultTransaction table
    //     VaultTransaction::create([
    //         'type' => $request->type,
    //         'amount' => $request->amount,
    //         'reason' => $request->reason,
    //         'user_id' => Auth::id(),
    //     ]);

    //     // If withdrawal from vault, also store in bank_transactions
    //     if ($request->type === 'out') {
    //         BankTransaction::create([
    //             'user_id' => Auth::id(),
    //             'amount' => $request->amount,
    //             'bank_name' => $request->bank_name,
    //             'payment_method' => 'withdrawal_from_vault',
    //             'reference' => 'VAULT-' . strtoupper(uniqid()),
    //             'date' => now(),
    //         ]);
    //     }

    //     return back()->with('success', 'Vault transaction recorded successfully.');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'type' => 'required|in:in,out',
    //         'amount' => 'required|numeric|min:1',
    //         'reason' => 'nullable|string|max:255',
    //         'bank_name' => $request->type === 'in' ? 'required|string|max:255' : 'nullable',
    //     ]);
    
    //     $amount = $request->type === 'out' ? -abs($request->amount) : abs($request->amount);
    
    //     // Store vault transaction
    //     VaultTransaction::create([
    //         'type' => $request->type,
    //         'amount' => $amount,
    //         'reason' => $request->reason,
    //         'user_id' => auth()->id(),
    //     ]);
    
    //     // If depositing to vault from a bank, subtract from bank balance
    //     if ($request->type === 'in') {
    //         \App\Models\BankTransaction::create([
    //             'user_id' => auth()->id(),
    //             'amount' => -abs($request->amount), // debit bank
    //             'bank_name' => $request->bank_name,
    //             'payment_method' => 'vault_deposit',
    //             'reference' => 'VAULT-BANK-' . strtoupper(uniqid()),
    //             'date' => now(),
    //         ]);
    //     }
    
    //     return back()->with('success', 'Vault transaction recorded successfully.');
    // }

    public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:in,out',
        'amount' => 'required|numeric|min:1',
        'reason' => 'nullable|string|max:255',
        'bank_name' => $request->type === 'in' ? 'required|string|max:255' : 'nullable',
    ]);

    // If type is 'out', amount becomes negative (vault to bank)
    $amount = $request->type === 'out' ? -abs($request->amount) : abs($request->amount);

    // 1. Save Vault Transaction
    VaultTransaction::create([
        'type' => $request->type,
        'amount' => $amount,
        'reason' => $request->reason,
        'user_id' => auth()->id(),
    ]);

    // 2. Create a corresponding Bank Transaction
    if ($request->type === 'in') {
        // Vault receives money from bank → bank is debited
        \App\Models\BankTransaction::create([
            'user_id'        => auth()->id(),
            'amount'         => -abs($request->amount), // negative → debit
            'debit'          => abs($request->amount),  // fill debit
            'credit'         => 0.00,
            'bank_name'      => $request->bank_name,
            'payment_method' => 'vault_deposit',
            'reference'      => 'VAULT-BANK-' . strtoupper(uniqid()),
            'date'           => now(),
        ]);
    } elseif ($request->type === 'out') {
        // Vault sends money to bank → bank is credited
        \App\Models\BankTransaction::create([
            'user_id'        => auth()->id(),
            'amount'         => abs($request->amount),  // positive → credit
            'credit'         => abs($request->amount),
            'debit'          => 0.00,
            'bank_name'      => $request->bank_name,
            'payment_method' => 'vault_withdrawal',
            'reference'      => 'VAULT-BANK-' . strtoupper(uniqid()),
            'date'           => now(),
        ]);
    }

    return back()->with('success', 'Vault transaction recorded successfully.');
}



    public function report(Request $request)
{
    $query = \App\Models\VaultTransaction::query();

    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('created_at', [$request->from, $request->to]);
    }

    $totalIn = (clone $query)->where('type', 'in')->sum('amount');
    $totalOut = (clone $query)->where('type', 'out')->sum('amount');

    $balance = $totalIn + $totalOut; // out is stored as negative, so sum works

    $transactions = $query->latest()->get();

    return view('vault.report', compact('transactions', 'totalIn', 'totalOut', 'balance'));
}

    

}
