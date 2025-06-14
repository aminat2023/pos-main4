<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Transactions;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Method to display a list of orders
    public function index()
    {
        // Fetch all orders with their details
        $orders = Order::with('orderDetails.product')->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        // Logic to show the order creation form
        $products = Products::all(); // Fetch all products for selection
        return view('orders.create', compact('products'));
    }

    // public function store(Request $request)
    // {
    //     // Validate essential fields
    //     $request->validate([
    //         'balance' => 'required|numeric',
    //         'paid_amount' => 'required|numeric',
    //         'payment_method' => 'required|string',
    //         'customer_name' => 'required|string',
    //         'customer_phone' => 'required|string',
    //         'product_id' => 'required|array',
    //         'product_id.*' => 'required|integer',
    //         'quantity' => 'required|array',
    //         'quantity.*' => 'required|integer|min:1',
    //         'selling_price' => 'required|array',
    //         'selling_price.*' => 'required|numeric',
    //     ]);

    //     DB::beginTransaction(); // Start a transaction

    //     try {
    //         // Step 1: Create a new order
    //         $order = new Order();
    //         $order->name = $request->customer_name;
    //         $order->phone = $request->customer_phone;
    //         $order->save();

    //         $order_id = $order->id; // Get the newly created order ID

    //         // Step 2: Save the order details and update stock
    //         foreach ($request->product_id as $index => $product_id) {
    //             $quantity = $request->quantity[$index];
    //             $selling_price = $request->selling_price[$index];
    //             $total_amount = $selling_price * $quantity;

    //             // Check if enough stock is available
    //             $product = Products::find($product_id);
    //             if ($product->quantity < $quantity) {
    //                 DB::rollBack();
    //                 return redirect()->back()->with('error', 'Not enough stock for product: ' . $product->product_name);
    //             }

    //             // Save order details
    //             $order_details = new OrderDetails();
    //             $order_details->order_id = $order_id;
    //             $order_details->product_id = $product_id;
    //             $order_details->selling_price = $selling_price;
    //             $order_details->quantity = $quantity;
    //             $order_details->amount = $total_amount;
    //             $order_details->discount = $request->discount[$index] ?? 0; // Optional discount
    //             $order_details->save();

    //             // Step 3: Reduce the stock quantity
    //             $product->quantity -= $quantity;
    //             $product->save();
    //         }

    //         // Step 4: Save transaction details
    //         $transaction = new Transactions();
    //         $transaction->order_id = $order_id;

    //         if (auth()->check()) {
    //             $transaction->user_id = auth()->user()->id;
    //         } else {
    //             DB::rollBack();
    //             return redirect()->back()->with('error', 'User is not authenticated.');
    //         }

    //         $transaction->balance = $request->balance;
    //         $transaction->paid_amount = $request->paid_amount;
    //         $transaction->payment_method = $request->payment_method;
    //         $transaction->transaction_amount = array_sum(array_map(function ($selling_price, $quantity) {
    //             return $selling_price * $quantity;
    //         }, $request->selling_price, $request->quantity));
    //         $transaction->transaction_date = now();
    //         $transaction->save();

    //         DB::commit(); // Commit transaction if everything is successful

    //         // Truncate the cart after successful transaction
    //         Cart::truncate(); // This clears the entire cart

    //         // Fetch the last transaction for display
    //         $lastTransaction = Transactions::with('order.orderDetails.product')->latest()->first();

    //         return redirect()->route('orders.index')->with([
    //             'success' => 'Order created successfully!',
    //             'lastTransaction' => $lastTransaction, // Pass the last transaction to the view
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Order creation failed: ' . $e->getMessage());
    //     }
    // }
    public function store(Request $request)
{
    // Validate essential fields
    $request->validate([
        'balance' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'payment_method' => 'required|string',
        'customer_name' => 'required|string',
        'customer_phone' => 'required|string',
        'product_id' => 'required|array',
        'product_id.*' => 'required|integer',
        'quantity' => 'required|array',
        'quantity.*' => 'required|integer|min:1',
        'selling_price' => 'required|array',
        'selling_price.*' => 'required|numeric',
    ]);

    DB::beginTransaction(); // Start a transaction

    try {
        // Step 1: Create a new order
        $order = new Order();
        $order->name = $request->customer_name;
        $order->phone = $request->customer_phone;
        $order->save();

        $order_id = $order->id; // Get the newly created order ID

        // Step 2: Save the order details and update stock
        foreach ($request->product_id as $index => $product_id) {
            $quantity = $request->quantity[$index];
            $selling_price = $request->selling_price[$index];
            $total_amount = $selling_price * $quantity;

            // Fetch product and its stocks in FIFO order
            $product = Products::with('stocks')->find($product_id);
            $stocks = $product->stocks()->orderBy('created_at')->get();

            $remainingQuantity = $quantity;

            foreach ($stocks as $stock) {
                if ($remainingQuantity <= 0) {
                    break; // Stop if we've sold enough
                }

                if ($stock->quantity >= $remainingQuantity) {
                    // Update stock quantity and save order details
                    $stock->quantity -= $remainingQuantity;
                    $stock->save();

                    // Save order details
                    $order_details = new OrderDetails();
                    $order_details->order_id = $order_id;
                    $order_details->product_id = $product_id;
                    $order_details->selling_price = $selling_price;
                    $order_details->quantity = $remainingQuantity;
                    $order_details->amount = $total_amount;
                    $order_details->discount = $request->discount[$index] ?? 0; // Optional discount
                    $order_details->save();

                    $remainingQuantity = 0; // All sold
                } else {
                    // Sell all of this stock
                    $remainingQuantity -= $stock->quantity;
                    $order_details = new OrderDetails();
                    $order_details->order_id = $order_id;
                    $order_details->product_id = $product_id;
                    $order_details->selling_price = $selling_price;
                    $order_details->quantity = $stock->quantity;
                    $order_details->amount = $stock->quantity * $selling_price;
                    $order_details->discount = $request->discount[$index] ?? 0; // Optional discount
                    $order_details->save();

                    // Delete stock entry if it's fully sold
                    $stock->delete();
                }
            }

            // If there is remaining quantity, rollback
            if ($remainingQuantity > 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Not enough stock for product: ' . $product->product_name);
            }
        }

        // Step 4: Save transaction details
        $transaction = new Transactions();
        $transaction->order_id = $order_id;

        if (auth()->check()) {
            $transaction->user_id = auth()->user()->id;
        } else {
            DB::rollBack();
            return redirect()->back()->with('error', 'User is not authenticated.');
        }

        $transaction->balance = $request->balance;
        $transaction->paid_amount = $request->paid_amount;
        $transaction->transaction_amount = array_sum(array_map(function ($selling_price, $quantity) {
            return $selling_price * $quantity;
        }, $request->selling_price, $request->quantity));
        $transaction->transaction_date = now();
        $transaction->save();

        DB::commit(); // Commit transaction if everything is successful

        // Truncate the cart after successful transaction
        Cart::truncate(); // This clears the entire cart

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Order creation failed: ' . $e->getMessage());
    }
}


    // Other methods (show, edit, update, destroy) remain unchanged
}
