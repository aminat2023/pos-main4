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

    // public function store(Request $request)
    // {
    //     // Validate incoming request data
    //     $request->validate([
    //         'product_code' => 'required|string|exists:products_two,product_code',
    //         'quantity' => 'required|integer|min:1',
    //         'cost_price' => 'required|numeric|min:0',
    //         'selling_price' => 'required|numeric|min:0',
    //     ]);
    
    //     // Retrieve the product details from the products_two table
    //     $product = ProductTwo::where('product_code', $request->product_code)->first();
    
    //     // Calculate total stock for the product
    //     $totalStock = IncomingStock::where('product_code', $request->product_code)->sum('quantity') + $request->quantity;
    
    //     // Create a new incoming stock record
    //     IncomingStock::create([
    //         'product_code' => $request->product_code,
    //         'product_name' => $product->product_name, // Save the product name
    //         'quantity' => $request->quantity,
    //         'cost_price' => $request->cost_price,
    //         'selling_price' => $request->selling_price,
    //         'total_stock' => $totalStock,
    //         'batch_date' => now(),
    //     ]);
    
    //     // Redirect with success message
    //     return redirect()->route('incoming_stock.index')->with('success', 'Incoming stock added successfully.');
    // }

    public function store(Request $request)
    {
        // Validate incoming request data
        Log::info('Incoming stock store method called', $request->all());
    // Validate incoming request data
    $validatedData = $request->validate([
        'product_code' => 'required|string|exists:products_two,product_code',
        'quantity' => 'required|integer|min:1',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0|gt:cost_price',
    ]);
    
        // Retrieve the product details from the products_two table
        $product = ProductTwo::where('product_code', $request->product_code)->first();
    
        // Calculate total stock for the product
        $totalStock = IncomingStock::where('product_code', $request->product_code)->sum('quantity') + $request->quantity;
    
        // Create a new incoming stock record
        try {
            IncomingStock::create([
                'product_code' => $request->product_code,
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
    
    
    


    public function search(Request $request)
    {
        $query = $request->input('search');
        $products = ProductTwo::where('product_name', 'LIKE', "%{$query}%")
                           ->orWhere('product_code', 'LIKE', "%{$query}%")
                           ->get(['product_code', 'product_name']); // Specify fields to return
    
        return response()->json($products);
    }
}