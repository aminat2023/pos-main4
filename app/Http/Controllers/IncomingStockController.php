<?php

namespace App\Http\Controllers;

use App\Models\IncomingStock;
use App\Models\ProductTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncomingStockController extends Controller
{
   
public function index()
{
    $products = ProductTwo::all(); // Fetch all products
    $incomingStocks = IncomingStock::all(); // Fetch all incoming stocks

    return view('incoming_stock.index', compact('products', 'incomingStocks'));
}

   

public function store(Request $request)
{
    // Extract product code from formatted string
    $productCode = $request->input('product_code');
    
    $validatedData = $request->validate([
        'product_code' => 'required|string|exists:products_two,product_code',
        'quantity' => 'required|integer|min:1',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0|gt:cost_price',
    ]);

    $product = ProductTwo::where('product_code', $productCode)->first();
    
    $totalStock = IncomingStock::where('product_code', $productCode)
                                ->sum('quantity') + $request->quantity;
    
    try {
        IncomingStock::create([
            'product_code' => $productCode,
            'product_name' => $product->product_name,
            'quantity' => $request->quantity,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'total_stock' => $totalStock,
            'batch_date' => now(),
        ]);
    
        return redirect()->route('incoming_stock.index')->with('success', 'Incoming stock added successfully.');
    } catch (\Exception $e) {
        Log::error('Error saving incoming stock: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to save incoming stock. Please try again.')->withInput();
    }
}





    
    
    
}