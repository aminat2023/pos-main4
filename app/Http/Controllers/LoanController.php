<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    public function index()
    {
        $approvedLoans = Loan::where('status', 'approved')->orderBy('approved_at', 'desc')->get();
    
        return view('loans.index', compact('approvedLoans'));
    }
    

    public function create()
    {
        return view('loans.create');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
    
            'nin' => 'required|string',
            'gov_id' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'utility_bill' => 'required|file|mimes:jpg,jpeg,png,pdf',
    
            'employment_status' => 'required|string',
            'monthly_income' => 'required|numeric',
    
            'bank_statements' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'loan_amount' => 'required|numeric|min:1000',
            'loan_purpose' => 'required|string',
            'repayment_plan' => 'required|string',
        ]);
    
        // ✅ Generate Unique Account Number
        $accountNumber = 'LN-' . strtoupper(Str::random(8));
    
        // ✅ Upload Files
        $govId = $request->file('gov_id')->store('loan_docs');
        $utilityBill = $request->file('utility_bill')->store('loan_docs');
        $bankStatements = $request->file('bank_statements')->store('loan_docs');
        $collateral = $request->hasFile('collateral_docs') 
            ? $request->file('collateral_docs')->store('loan_docs') 
            : null;
    
        // ✅ Save Loan
        Loan::create([
            'account_number'     => $accountNumber,
            'full_name'          => $request->full_name,
            'dob'                => $request->dob,
            'gender'             => $request->gender,
            'marital_status'     => $request->marital_status,
            'address'            => $request->address,
            'phone'              => $request->phone,
            'email'              => $request->email,
            'nin'                => $request->nin,
            'gov_id'             => $govId,
            'utility_bill'       => $utilityBill,
            'employment_status'  => $request->employment_status,
            'employer_name'      => $request->employer_name,
            'employer_address'   => $request->employer_address,
            'job_title'          => $request->job_title,
            'monthly_income'     => $request->monthly_income,
            'bank_statements'    => $bankStatements,
            'credit_history'     => $request->credit_history,
            'existing_debts'     => $request->existing_debts,
            'loan_amount'        => $request->loan_amount,
            'loan_purpose'       => $request->loan_purpose,
            'repayment_plan'     => $request->repayment_plan,
            'collateral_docs'    => $collateral,
            'guarantor_info'     => $request->guarantor_info,
            'status'             => 'Pending',
        ]);
    
        return redirect()->route('loans.create')->with('success', 'Loan submitted successfully!');
    }
    

   


    // Approve the loan
// Approve the loan
public function approve($id)
{
    $loan = Loan::findOrFail($id);
    $loan->status = 'approved';
    $loan->approved_at = now();
    $loan->save();

    return redirect()->route('loans.index')->with('success', 'Loan approved successfully.');
}

public function show($id)
{
    $loan = Loan::findOrFail($id);
    $repayments = \App\Models\LoanRepayment::where('loan_id', $id)->get();
    $totalRepaid = $repayments->sum('amount_paid');
    $balance = $loan->loan_amount - $totalRepaid;

    return view('loans.show', compact('loan', 'repayments', 'totalRepaid', 'balance'));
}



}
