<?php

namespace App\Http\Controllers;

use App\Models\IncomingStock;
use App\Models\ProductTwo;
use App\Models\Supply;
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
    $productCode = $request->input('product_code');

    $validatedData = $request->validate([
        'product_code' => 'required|string|exists:products_two,product_code',
        'quantity' => 'required|integer|min:1',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0|gt:cost_price',
    ]);

    $product = ProductTwo::where('product_code', $productCode)->first();

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.')->withInput();
    }

    // Save the new incoming stock first
    $newStock = IncomingStock::create([
        'product_code' => $productCode,
        'product_name' => $product->product_name,
        'quantity' => $request->quantity,
        'cost_price' => $request->cost_price,
        'selling_price' => $request->selling_price,
        'batch_date' => now(),
    ]);

    // 🧮 After inserting, calculate total quantity of all rows with same product_code
    $total = IncomingStock::where('product_code', $productCode)->sum('quantity');

    // ✅ Update the total_stock field for all rows with this product_code
    IncomingStock::where('product_code', $productCode)->update(['total_stock' => $total]);

    return redirect()->route('incoming_stock.index')->with('success', 'Incoming stock added successfully.');
}




public function importFromSupplies()
{
    $supplies = Supply::orderBy('created_at')->get(); // Oldest first

    foreach ($supplies as $supply) {
        // Skip if already imported
        $exists = IncomingStock::where('product_name', $supply->product_name)
                               ->where('quantity', $supply->quantity)
                               ->whereDate('batch_date', $supply->created_at->toDateString())
                               ->exists();

        if ($exists) {
            continue;
        }

        $product = ProductTwo::where('product_name', $supply->product_name)->first();
        if (!$product) {
            continue; // Skip if no matching product
        }

        $totalStock = IncomingStock::where('product_code', $product->product_code)->sum('quantity') + $supply->quantity;

        IncomingStock::create([
            'product_code'    => $product->product_code,
            'product_name'    => $product->product_name,
            'quantity'        => $supply->quantity,
            'cost_price'      => $product->cost_price ?? 0,
            'selling_price'   => $product->selling_price ?? 0,
            'total_stock'     => $totalStock,
            'batch_date'      => $supply->created_at,
        ]);
    }

    return redirect()->route('incoming_stock.index')->with('success', 'Supplies imported into stock successfully.');
}


public function reviewBatch()
{
    $supplies = Supply::orderBy('created_at')->get(); // Oldest first
    return view('incoming_stock.review_batch', compact('supplies'));
}

public function submitBatch(Request $request)
{
    $data = $request->input('stocks', []);

    foreach ($data as $item) {
        if (
            empty($item['id']) || empty($item['product_name']) || 
            empty($item['quantity']) || empty($item['cost_price']) || 
            empty($item['selling_price'])
        ) {
            continue;
        }

        $product = ProductTwo::where('product_name', $item['product_name'])->first();
        if (!$product) continue;

        $totalStock = IncomingStock::where('product_code', $product->product_code)->sum('quantity') + $item['quantity'];

        IncomingStock::create([
            'product_code'   => $product->product_code,
            'product_name'   => $item['product_name'],
            'quantity'       => $item['quantity'],
            'cost_price'     => $item['cost_price'],
            'selling_price'  => $item['selling_price'],
            'total_stock'    => $totalStock,
            'batch_date'     => now(),
        ]);

        // ✅ Remove the imported supply
        Supply::where('id', $item['id'])->delete();
    }

    return redirect()->route('incoming_stock.review_batch')->with('success', 'Imported supplies saved and removed from the table.');
}

   
    
    
}