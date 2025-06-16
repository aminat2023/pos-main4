<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
        return view('supplies.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        Supply::create($request->all());

        return redirect()->route('supplies.create')->with('success', 'Supply recorded successfully.');
    }
}
