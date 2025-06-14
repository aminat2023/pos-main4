<?php

namespace App\Http\Controllers;

use App\Models\CounterCart;
use App\Models\IncomingStock;
use Illuminate\Http\Request;
use App\Models\CounterSalesDetail; 
use Illuminate\Support\Facades\Auth; // Import Auth facade

class CounterSalesController extends Controller
{
    public function index()
    {
        $sales = CounterCart::all();
        return view('counter_sales.index', compact('sales'));
    }

    public function create()
    {
        return view('counter_sales.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'product_code' => 'required|array',
            'quantity' => 'required|array',
            'selling_price' => 'required|array',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'payment_method' => 'required|string',
            'paid_amount' => 'required|numeric',
        ]);
    
        // Prepare the sales details for insertion
        $salesDetails = [];
        $totalAmount = 0; // Initialize total amount
    
        foreach ($request->product_code as $index => $productCode) {
            $quantity = $request->quantity[$index];
            $sellingPrice = $request->selling_price[$index];
    
            $amount = $quantity * $sellingPrice; // Calculate total amount for each item
            $totalAmount += $amount; // Add to total amount
    
            $salesDetails[] = [
                'user_id' => auth()->id(),
                'product_name' => 'Product Name Here', // Replace with actual product name if available
                'product_code' => $productCode,
                'quantity' => $quantity,
                'selling_price' => $sellingPrice,
                'total_amount' => $amount,
                'amount_paid' => $request->paid_amount,
                'balance' => $request->paid_amount - $totalAmount,
                'method_of_payment' => $request->payment_method,
                'discount' => $request->discount ?? 0, // Optional discount field
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // Try to insert sales details into the database
        try {
            CounterSalesDetail::insert($salesDetails);
            session()->flash('message', 'Order saved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save order: ' . $e->getMessage());
        }
    
        // Redirect or return response as needed
        return redirect()->route('counter_sales.index'); // Adjust the route as necessary
    }
    
}
