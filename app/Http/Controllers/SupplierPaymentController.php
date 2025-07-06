<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use App\Models\Supply;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
   

    public function create($supplyId)
{
    $supply = \App\Models\Supply::with('supplier')->findOrFail($supplyId); // ensures latest amount_paid and balance

    $vaultBalance = \App\Models\MoneyBox::where('bank_name', 'Vault')->value('balance') ?? 0;

    $banks = getPreference('banks', []);
    if (!is_array($banks)) $banks = [];

    $bankBalances = [];
    foreach ($banks as $bank) {
        $bankBalances[$bank] = \App\Models\MoneyBox::where('bank_name', $bank)->value('balance') ?? 0;
    }

    return view('supplier_payments.create', compact('supply', 'vaultBalance', 'bankBalances'));
}

    
public function store(Request $request)
{
    $request->validate([
        'supply_id'     => 'required|exists:supplies,id',
        'amount_paid'   => 'required|numeric|min:0.01',
        'payment_mode'  => 'required|string',
    ]);

    $supply = Supply::with('supplier')->findOrFail($request->supply_id);
    $amountPaid = $request->amount_paid;

    // 🛑 Check if full payment has already been made
    if ($supply->balance <= 0) {
        return back()->with('error', 'Full payment has already been made for this supply.');
    }

    // 🛑 Check vault or bank balance
    if ($request->payment_mode === 'cash') {
        $vaultBalance = \App\Models\MoneyBox::where('bank_name', 'Vault')->value('balance') ?? 0;
        if ($vaultBalance < $amountPaid) {
            return back()->with('error', 'Insufficient vault balance.');
        }
    } else {
        $bankBalance = \App\Models\MoneyBox::where('bank_name', $request->payment_mode)->value('balance') ?? 0;
        if ($bankBalance < $amountPaid) {
            return back()->with('error', 'Insufficient balance in ' . $request->payment_mode . ' bank.');
        }
    }

    // 🧾 Generate invoice number from supply ID
    $invoiceNumber = 'INV' . str_pad($supply->id, 5, '0', STR_PAD_LEFT);

    // ✅ Check if this invoice already exists
    if (SupplierPayment::where('invoice_number', $invoiceNumber)->exists()) {
        return back()->with('error', 'Payment has already been made for this supply.')->withInput();
    }

    // 🧮 Calculate payment
    $newAmountPaid = $supply->amount_paid + $amountPaid;
    $newBalance = $supply->amount - $newAmountPaid;
    $paymentStatus = $newBalance <= 0 ? 'paid' : 'partial';

    // 💾 Create payment record
    $payment = SupplierPayment::create([
        'supply_id'      => $supply->id,
        'supplier_id'    => $supply->supplier_id,
        'product_name'   => $supply->product_name,
        'quantity'       => $supply->quantity,
        'amount'         => $supply->amount,
        'amount_paid'    => $amountPaid,
        'balance'        => $newBalance,
        'payment_mode'   => $request->payment_mode,
        'invoice_number' => $invoiceNumber,
    ]);

    // 🔄 Update supply
    $supply->update([
        'amount_paid'    => $newAmountPaid,
        'balance'        => $newBalance,
        'payment_status' => $paymentStatus,
    ]);

    // 💳 Deduct from bank or vault
    $source = $request->payment_mode === 'cash' ? 'Vault' : $request->payment_mode;
    $moneyBox = \App\Models\MoneyBox::where('bank_name', $source)->first();
    if ($moneyBox) {
        $moneyBox->balance -= $amountPaid;
        $moneyBox->save();
    }

    return redirect()->route('supplier_payments.invoice', $payment->id)
        ->with('success', 'Payment recorded successfully.');
}





    
    public function showInvoice($id)
{
    $payment = SupplierPayment::with('supply', 'supply.supplier')->findOrFail($id);

    return view('supplier_payments.invoice', compact('payment'));
}
}
