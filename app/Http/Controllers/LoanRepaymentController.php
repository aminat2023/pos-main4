<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Illuminate\Http\Request;

class LoanRepaymentController extends Controller
{
    public function create(Loan $loan)
    {
        return view('repayments.create', compact('loan'));
    }

    public function store(Request $request, Loan $loan)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:1',
            'payment_method' => 'nullable|string',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        LoanRepayment::create([
            'loan_id' => $loan->id,
            'amount_paid' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'note' => $request->note,
        ]);

        return redirect()->route('loans.index')->with('success', 'Repayment recorded successfully.');
    }
}
