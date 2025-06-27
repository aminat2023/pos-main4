<?php

namespace App\Http\Controllers;
use App\Models\Supply;
use App\Models\Supplier;
use App\Models\ProductTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::with('supplier')->latest()->get();
        return view('supplies.index', compact('supplies'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = ProductTwo::all();

        return view('supplies.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);
    
        // Use selected supplier or fallback to anonymous supplier
        $supplierId = $request->supplier_id;
        $supplierName = 'Anonymous Supplier';
    
        if ($supplierId) {
            $supplier = Supplier::find($supplierId);
            $supplierName = $supplier->name ?? $supplierName;
        } else {
            $anonymous = Supplier::firstOrCreate(
                ['name' => 'Anonymous Supplier'],
                ['contact' => null, 'email' => null]
            );
            $supplierId = $anonymous->id;
        }
    
        // Calculate amount
        $amount = $request->unit_price * $request->quantity;
    
        // Create supply
        $supply = Supply::create([
            'supplier_id'    => $supplierId,
            'supplier_name'  => $supplierName,
            'product_name'   => $request->product_name,
            'quantity'       => $request->quantity,
            'unit_price'     => $request->unit_price,
            'amount'         => $amount,
            'amount_paid'    => 0,
            'balance'        => $amount,
            'payment_status' => 'unpaid',
        ]);
    
        if (Schema::hasColumn('supplies', 'supply_id')) {
            $customId = 'GDSup' . str_pad($supply->id, 3, '0', STR_PAD_LEFT);
            $supply->update(['supply_id' => $customId]);
        }
    
        return redirect()->route('supplier_payments.create', ['supply_id' => $supply->id])
                         ->with('success', 'Supply recorded successfully. Proceed to payment.');
    }
    
}
