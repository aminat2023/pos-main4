<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TillCollection;
use App\Models\TillWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class TillWithdrawalController extends Controller
{
    /**
     * Display all past withdrawals
     */
    public function index()
    {
        $withdrawals = TillWithdrawal::with(['admin', 'cashier'])->latest()->get();
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

    /**
     * Store a withdrawal
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'cashier_id'    => 'required|exists:users,id',
    //         'destination'   => 'required|in:bank,vault',
    //         'denominations' => 'required|array',
    //     ]);

    //     // Compute the total withdrawal amount from denominations
    //     $totalAmount = 0;
    //     foreach ($request->denominations as $note => $count) {
    //         $totalAmount += ((int) $note) * ((int) $count);
    //     }

    //     // Save the withdrawal
    //     TillWithdrawal::create([
    //         'admin_id'      => Auth::id(),
    //         'cashier_id'    => $request->cashier_id,
    //         'destination'   => $request->destination,
    //         'denominations' => json_encode($request->denominations),
    //         'total_amount'  => $totalAmount,
    //         'notes'         => $request->notes,
    //     ]);

    //     return redirect()->route('till.withdraw.create')->with('success', 'Till money withdrawn and recorded successfully!');
    // }
    

  

public function store(Request $request)
{
    $request->validate([
        'cashier_id'    => 'required|exists:users,id',
        'destination'   => 'required|in:bank,vault',
        'denominations' => 'required|array',
        'admin_password' => 'required|string',
    ]);

    // Authenticate admin by checking password
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
    \App\Models\TillWithdrawal::create([
        'admin_id'      => $admin->id,
        'cashier_id'    => $request->cashier_id,
        'destination'   => $request->destination,
        'denominations' => json_encode($request->denominations),
        'total_amount'  => $totalAmount,
        'notes'         => $request->notes,
    ]);

    return redirect()->route('till.withdraw.create')->with('success', 'Till money withdrawn and recorded successfully!');
}

    

}
