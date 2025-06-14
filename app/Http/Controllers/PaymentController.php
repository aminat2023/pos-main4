<?php
namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sale; // Include the Sale model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{  public function index()
    {
        $products = Sale::all(); // Fetch all incoming products
        return view('payment.counter', compact('products')); // Pass products to the view
    }

    // public function store(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'product_name' => 'required|array',
    //         'product_name.*' => 'required|string',
    //         'product_qty' => 'required|array',
    //         'product_qty.*' => 'required|integer|min:1',
    //         'cost_price' => 'required|array',
    //         'cost_price.*' => 'required|numeric',
    //         'selling_price' => 'required|array',
    //         'selling_price.*' => 'required|numeric',
    //         'method_of_payment' => 'required|string',
    //         'paid_amount' => 'required|numeric|min:0',
    //         'balance' => 'required|numeric|min:0',
    //     ]);

    //     DB::beginTransaction(); // Start a database transaction

    //     try {
    //         // Log the incoming request data for debugging
    //         Log::info('Incoming request data:', $request->all());

    //         // Prepare to save each sale
    //         foreach ($request->product_name as $index => $product_name) {
    //             // Find the incoming product
    //             $incomingProduct = Products::where('product_name', $product_name)->first();

    //             if (!$incomingProduct || $incomingProduct->quantity < $request->product_qty[$index]) {
    //                 DB::rollBack();
    //                 Log::warning('Not enough stock for product: ' . $product_name);
    //                 return redirect()->back()->withErrors(['quantity' => 'Not enough stock for product: ' . $product_name]);
    //             }

    //             // Calculate profit
    //             $profit = $request->selling_price[$index] - $request->cost_price[$index];

    //             // Create Sale record
    //             Sale::create([
    //                 'product_name' => $product_name,
    //                 'product_qty' => $request->product_qty[$index],
    //                 'cost_price' => $request->cost_price[$index],
    //                 'selling_price' => $request->selling_price[$index],
    //                 'profit' => $profit,
    //                 'method_of_payment' => $request->method_of_payment,
    //                 'amount_paid' => $request->paid_amount,
    //                 'balance' => $request->balance,
    //                 'user_id' => auth()->id(), // Associate with authenticated user
    //                 'product_code' => $incomingProduct->product_code,
    //             ]);

    //             // Update incoming product stock
    //             $incomingProduct->quantity -= $request->product_qty[$index];
    //             $incomingProduct->save();
    //         }

    //         DB::commit(); // Commit the transaction
    //         Log::info('Sale recorded successfully!');

    //         return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Rollback the transaction on error
    //         Log::error('Failed to record sale: ' . $e->getMessage()); // Log the error
    //         return redirect()->back()->with('error', 'Failed to record sale: ' . $e->getMessage());
    //     }
    // }
}
