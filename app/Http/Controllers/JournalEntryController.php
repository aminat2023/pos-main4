<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JournalEntry;
use App\Models\VaultTransaction;
use App\Models\BankTransaction;
  

class JournalEntryController extends Controller
{
    public function index()
    {
        // Generate next reference number like AGJ-000001
        $last = JournalEntry::latest()->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $reference = 'AGJ-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return view('journal.index', compact('reference'));
    }

    
    
    public function store(Request $request)
    {
        $request->validate([
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'account'     => 'required|in:cash,bank',
            'type'        => 'required|in:debit,credit',
            'amount'      => 'required|numeric|min:0.01',
            'bank_name'   => 'nullable|string|max:255',
        ]);
    
        // Generate Reference
        $last = JournalEntry::latest()->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $reference = 'AGJ-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    
        $debit = $request->type === 'debit' ? $request->amount : 0.00;
        $credit = $request->type === 'credit' ? $request->amount : 0.00;
    
        $journal = JournalEntry::create([
            'reference'   => $reference,
            'account'     => $request->account,
            'bank_name'   => $request->account === 'bank' ? $request->bank_name : null,
            'debit'       => $debit,
            'credit'      => $credit,
            'description' => $request->description,
            'date'        => $request->date,
            'user_id'     => Auth::id(),
        ]);
    
        // 🔁 Sync to Vault or Bank
        if ($request->account === 'cash') {
            VaultTransaction::create([
                'type'     => $request->type,
                'amount'   => $request->amount,
                'debit'    => $request->type === 'debit' ? $request->amount : 0.00,
                'credit'   => $request->type === 'credit' ? $request->amount : 0.00,
                'reason'   => $request->description,
                'user_id'  => Auth::id(),
            ]);
        }
        
        if ($request->account === 'bank') {
            BankTransaction::create([
                'user_id'       => Auth::id(),
                'amount'        => $request->amount,
                'debit'         => $debit,
                'credit'        => $credit,
                'bank_name'     => $request->bank_name,
                'payment_method'=> 'journal', // optional label
                'date'          => $request->date,
            ]);
        }
    
        return redirect()->route('journal.index')->with('success', 'Journal entry saved and synced.');
    }
    
    
}
