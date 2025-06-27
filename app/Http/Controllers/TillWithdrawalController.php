<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TillCollection;
use App\Models\TillWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BankTransaction;
use App\Models\VaultTransaction;



class TillWithdrawalController extends Controller
{
    /**
     * Display all past withdrawals
     */
    public function index()
    {
        $withdrawals = \App\Models\TillWithdrawal::with(['admin', 'cashier'])->latest()->get();
    
        return view('till.index', compact('withdrawals'));
    }
    

    /**
     * Show withdrawal form with till balances per cashier
     */
    public function create()
    {
        $cashiers = User::all(); // You can later filter by role if needed
        $tillAmounts = [];

        foreach ($cashiers as $cashier) {
            $totalCollected = TillCollection::where('user_id', $cashier->id)
                                ->whereDate('date', today())
                                ->sum('amount');

            $totalWithdrawn = TillWithdrawal::where('cashier_id', $cashier->id)
                                ->whereDate('created_at', today())
                                ->sum('total_amount');

            $tillAmounts[$cashier->id] = $totalCollected - $totalWithdrawn;
        }

        return view('till.withdraw', compact('cashiers', 'tillAmounts'));
    }


   
    
  

public function store(Request $request)
{
    $request->validate([
        'cashier_id'    => 'required|exists:users,id',
        'destination'   => 'required|string',
        'denominations' => 'required|array',
        'admin_password' => 'required|string',
    ]);

    $admin = Auth::user();

    if (!Hash::check($request->admin_password, $admin->password)) {
        return redirect()->back()->withErrors(['admin_password' => 'Incorrect admin password.']);
    }

    // Calculate the total from denominations
    $totalAmount = 0;
    foreach ($request->denominations as $note => $count) {
        $totalAmount += ((int) $note) * ((int) $count);
    }

    // Save the withdrawal
    $withdrawal = \App\Models\TillWithdrawal::create([
        'admin_id'      => $admin->id,
        'cashier_id'    => $request->cashier_id,
        'destination'   => $request->destination,
        'denominations' => json_encode($request->denominations),
        'total_amount'  => $totalAmount,
        'notes'         => $request->notes,
    ]);

    // Save to credit only (not amount or debit)
    if ($request->destination === 'vault') {
        VaultTransaction::create([
            'credit'  => $totalAmount,
            'debit'   => 0,
            'reason'  => 'Till Withdrawal by Admin: ' . $admin->name,
            'user_id' => $admin->id,
        ]);
    } else {
        BankTransaction::create([
            'credit'         => $totalAmount,
            'debit'          => 0,
            'bank_name'      => $request->destination,
            'payment_method' => 'Till Withdrawal',
            'user_id'        => $admin->id,
            'date'           => now(),
        ]);
    }

    return redirect()->route('till.withdraw.create')->with('success', 'Till money withdrawn and recorded successfully!');
}

    

    

    

}
