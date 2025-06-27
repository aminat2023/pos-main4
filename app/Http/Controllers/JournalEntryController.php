<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\BankTransaction;
use App\Models\VaultTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalEntryController extends Controller
{
    // public function index()
    // {
    //     $last = JournalEntry::latest('id')->first();
    //     $nextId = $last ? $last->id + 1 : 1;
    //     $reference = 'AGJ-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

    //     return view('journal.index', compact('reference'));
    // }

    public function index()
{
    $last = JournalEntry::latest('id')->first();
    $nextId = $last ? $last->id + 1 : 1;
    $reference = 'AGJ-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

    $banks = getPreference('banks', []);

    if (!is_array($banks)) {
        $banks = [];
    }

    return view('journal.index', compact('reference', 'banks'));
}


    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'date' => 'required|date',
            'is_double_leg' => 'nullable|in:0,1'
        ]);

        $userId = Auth::id();
        $reference = $request->reference;
        $amount = $request->amount;

        if ($request->is_double_leg) {
            // Double-leg
            $entries = [
                [
                    'account' => $request->entry1_account,
                    'bank_name' => $request->entry1_account === 'bank' ? $request->bank_name_entry1 : null,
                    'type' => $request->entry1_type,
                ],
                [
                    'account' => $request->entry2_account,
                    'bank_name' => $request->entry2_account === 'bank' ? $request->bank_name_entry2 : null,
                    'type' => $request->entry2_type,
                ],
            ];

            foreach ($entries as $entry) {
                $journalEntry = JournalEntry::create([
                    'reference' => $reference,
                    'account' => $entry['account'],
                    'bank_name' => $entry['bank_name'],
                    'debit' => $entry['type'] === 'debit' ? $amount : 0.00,
                    'credit' => $entry['type'] === 'credit' ? $amount : 0.00,
                    'description' => $request->description,
                    'date' => $request->date,
                    'user_id' => $userId,
                ]);

                if ($entry['account'] === 'cash') {
                    VaultTransaction::create([
                        'user_id' => $userId,
                        'amount' => $amount,
                        'debit' => $entry['type'] === 'debit' ? $amount : 0.00,
                        'credit' => $entry['type'] === 'credit' ? $amount : 0.00,
                        'reason' => $request->description,
                    ]);
                } elseif ($entry['account'] === 'bank') {
                    BankTransaction::create([
                        'user_id' => $userId,
                        'amount' => $amount,
                        'debit' => $entry['type'] === 'debit' ? $amount : 0.00,
                        'credit' => $entry['type'] === 'credit' ? $amount : 0.00,
                        'bank_name' => $entry['bank_name'],
                        'payment_method' => 'journal',
                        'date' => $request->date,
                    ]);
                }
            }

        } else {
            // Single-leg
            $account = $request->account;
            $bankName = $account === 'bank' ? $request->bank_name : null;
            $type = $request->type;

            JournalEntry::create([
                'reference' => $reference,
                'account' => $account,
                'bank_name' => $bankName,
                'debit' => $type === 'debit' ? $amount : 0.00,
                'credit' => $type === 'credit' ? $amount : 0.00,
                'description' => $request->description,
                'date' => $request->date,
                'user_id' => $userId,
            ]);

            if ($account === 'cash') {
                VaultTransaction::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                    'debit' => $type === 'debit' ? $amount : 0.00,
                    'credit' => $type === 'credit' ? $amount : 0.00,
                    'reason' => $request->description,
                ]);
            } elseif ($account === 'bank') {
                BankTransaction::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                    'debit' => $type === 'debit' ? $amount : 0.00,
                    'credit' => $type === 'credit' ? $amount : 0.00,
                    'bank_name' => $bankName,
                    'payment_method' => 'journal',
                    'date' => $request->date,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Journal entry saved successfully.');
    }

    public function report(Request $request)
    {
        $entries = JournalEntry::query()
            ->when($request->filled('from'), fn($q) => $q->whereDate('date', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('date', '<=', $request->to))
            ->when($request->filled('account'), fn($q) => $q->where('account', $request->account))
            ->when($request->filled('bank_name'), fn($q) => $q->where('bank_name', $request->bank_name))
            ->orderBy('date')
            ->get();

            $banks = getPreference('banks', []);
        return view('journal.report', compact('entries', 'banks'));
    }

    public function trialBalance()
    {
        $entries = JournalEntry::select('account', 'bank_name')
            ->selectRaw('SUM(debit) as total_debit')
            ->selectRaw('SUM(credit) as total_credit')
            ->groupBy('account', 'bank_name')
            ->get();

        return view('journal.trial_balance', compact('entries'));
    }

    public function ledger(Request $request)
    {
        $query = JournalEntry::query()
            ->orderBy('date')
            ->orderBy('id');

        if ($request->filled('account')) {
            $query->where('account', $request->account);
        }

        if ($request->filled('bank_name')) {
            $query->where('bank_name', $request->bank_name);
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $entries = $query->get();
        $banks = getPreference('banks', []);
        return view('journal.ledger', compact('entries', 'banks'));
    }
}
