<?php

namespace App\Http\Controllers;

use App\Models\BankTransaction;
use App\Models\JournalEntry;
use App\Models\MoneyBox;
use App\Models\VaultTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\TrialBalanceExport;
use App\Exports\LedgerExport;
use Maatwebsite\Excel\Facades\Excel;

class JournalEntryController extends Controller
{
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
        $rules = [
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'date' => 'required|date',
            'is_double_leg' => 'nullable|boolean',
        ];

        if ($request->is_double_leg) {
            $rules['entry1_account'] = 'required|string';
            $rules['entry1_type'] = 'required|in:debit,credit';
            $rules['entry2_account'] = 'required|string';
            $rules['entry2_type'] = 'required|in:debit,credit';

            if ($request->entry1_account === 'bank') {
                $rules['bank_name_entry1'] = 'required|string';
            }

            if ($request->entry2_account === 'bank') {
                $rules['bank_name_entry2'] = 'required|string';
            }
        } else {
            $rules['account'] = 'required|string';
            $rules['type'] = 'required|in:debit,credit';

            if ($request->account === 'bank') {
                $rules['bank_name'] = 'required|string';
            }
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            $userId = Auth::id();
            $amount = $request->amount;
            $date = $request->date;
            $desc = $request->description;

            if ($request->is_double_leg) {
                // Entry 1
                JournalEntry::create([
                    'user_id' => $userId,
                    'account' => $request->entry1_account,
                    'bank_name' => $request->bank_name_entry1 ?? null,
                    'debit' => $request->entry1_type === 'debit' ? $amount : 0,
                    'credit' => $request->entry1_type === 'credit' ? $amount : 0,
                    'description' => $desc,
                    'date' => $date,
                ]);
                $this->logTransaction($request->entry1_account, $request->entry1_type, $amount, $userId, $date, $request->bank_name_entry1 ?? null, $desc);
                $this->updateMoneyBox($request->entry1_account, $request->bank_name_entry1 ?? null);

                // Entry 2
                JournalEntry::create([
                    'user_id' => $userId,
                    'account' => $request->entry2_account,
                    'bank_name' => $request->bank_name_entry2 ?? null,
                    'debit' => $request->entry2_type === 'debit' ? $amount : 0,
                    'credit' => $request->entry2_type === 'credit' ? $amount : 0,
                    'description' => $desc,
                    'date' => $date,
                ]);
                $this->logTransaction($request->entry2_account, $request->entry2_type, $amount, $userId, $date, $request->bank_name_entry2 ?? null, $desc);
                $this->updateMoneyBox($request->entry2_account, $request->bank_name_entry2 ?? null);
            } else {
                JournalEntry::create([
                    'user_id' => $userId,
                    'account' => $request->account,
                    'bank_name' => $request->bank_name ?? null,
                    'debit' => $request->type === 'debit' ? $amount : 0,
                    'credit' => $request->type === 'credit' ? $amount : 0,
                    'description' => $desc,
                    'date' => $date,
                ]);
                $this->logTransaction($request->account, $request->type, $amount, $userId, $date, $request->bank_name ?? null, $desc);
                $this->updateMoneyBox($request->account, $request->bank_name ?? null);
            }

            DB::commit();
            return back()->with('success', 'Journal entry saved and money box updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to save journal entry. ' . $e->getMessage()]);
        }
    }

    private function logTransaction($account, $type, $amount, $userId, $date, $bankName = null, $desc = null)
    {
        $normalized = $account === 'cash' ? 'vault' : $account;

        if ($normalized === 'vault') {
            VaultTransaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'debit' => $type === 'debit' ? $amount : 0,
                'credit' => $type === 'credit' ? $amount : 0,
                'reason' => $desc,
                'date' => $date,
            ]);
        }

        if ($normalized === 'bank' && $bankName) {
            BankTransaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'debit' => $type === 'debit' ? $amount : 0,
                'credit' => $type === 'credit' ? $amount : 0,
                'bank_name' => $bankName,
                'payment_method' => 'journal',
                'reason' => $desc,
                'date' => $date,
            ]);
        }
    }

    private function updateMoneyBox($account, $bankName = null)
    {
        $normalized = $account === 'cash' ? 'vault' : $account;

        if ($normalized === 'vault') {
            $debit = VaultTransaction::sum('debit');
            $credit = VaultTransaction::sum('credit');
            $balance = $credit - $debit;

            MoneyBox::updateOrCreate(
                ['bank_name' => 'Vault'],
                ['balance' => $balance]
            );
        }

        if ($normalized === 'bank' && $bankName) {
            $debit = BankTransaction::where('bank_name', $bankName)->sum('debit');
            $credit = BankTransaction::where('bank_name', $bankName)->sum('credit');
            $balance = $credit - $debit;

            MoneyBox::updateOrCreate(
                ['bank_name' => $bankName],
                ['balance' => $balance]
            );
        }
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
        $entries = JournalEntry::select(
                DB::raw("CASE WHEN account = 'cash' THEN 'vault' ELSE account END as account"),
                'bank_name'
            )
            ->selectRaw('SUM(debit) as total_debit')
            ->selectRaw('SUM(credit) as total_credit')
            ->groupBy(DB::raw("CASE WHEN account = 'cash' THEN 'vault' ELSE account END"), 'bank_name')
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

        $entries = $query->get()->map(function ($entry) {
            if ($entry->account === 'cash') {
                $entry->account = 'vault';
            }
            return $entry;
        });

        $banks = getPreference('banks', []);
        return view('journal.ledger', compact('entries', 'banks'));
    }


    public function exportTrialBalance()
{
    return Excel::download(new TrialBalanceExport, 'trial_balance.xlsx');
}

public function exportLedger()
{
    return Excel::download(new LedgerExport, 'ledger.xlsx');
}
}
