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
        $supply = Supply::with('supplier')->findOrFail($supplyId);
        return view('supplier_payments.create', compact('supply')); // ✅ Show the form with data
    }
    

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'supply_id' => 'required|exists:supplies,id',
    //         'amount_paid' => 'required|numeric|min:0',
    //         'payment_mode' => 'required|string',
    //     ]);
    
    //     $supply = Supply::with('supplier')->findOrFail($request->supply_id);
    
    //     $balance = $supply->amount - $request->amount_paid;
    
    //     $payment = SupplierPayment::create([
    //         'supply_id'     => $supply->id,
    //         'supplier_id'   => $supply->supplier_id,
    //         'product_name'  => $supply->product_name,
    //         'quantity'      => $supply->quantity,
    //         'amount'        => $supply->amount,
    //         'amount_paid'   => $request->amount_paid,
    //         'balance'       => $balance,
    //         'payment_mode'  => $request->payment_mode,
    //         'invoice_number'=> 'INV' . str_pad($supply->id, 5, '0', STR_PAD_LEFT), // Example invoice format
    //     ]);
    
    //     return redirect()->route('supplier_payments.invoice', $payment->id);
    // }


    public function store(Request $request)
{
    $request->validate([
        'supply_id' => 'required|exists:supplies,id',
        'amount_paid' => 'required|numeric|min:0',
        'payment_mode' => 'required|string',
    ]);

    // Ensure full supply record is fetched
    $supply = Supply::with('supplier')->findOrFail($request->supply_id);

    $balance = $supply->amount - $request->amount_paid;

    $payment = SupplierPayment::create([
        'supply_id'     => $supply->id,
        'supplier_id'   => $supply->supplier_id,
        'product_name'  => $supply->product_name,
        'quantity'      => $supply->quantity,
        'amount'        => $supply->amount,
        'amount_paid'   => $request->amount_paid,
        'balance'       => $balance,
        'payment_mode'  => $request->payment_mode,
        'invoice_number'=> 'INV' . str_pad($supply->id, 5, '0', STR_PAD_LEFT),
    ]);

    return redirect()->route('supplier_payments.invoice', $payment->id);
}

    


    
    public function showInvoice($id)
{
    $payment = SupplierPayment::with('supply', 'supply.supplier')->findOrFail($id);

    return view('supplier_payments.invoice', compact('payment'));
}
}
