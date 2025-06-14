<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\IncomingProduct;
use App\Models\Sale;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentCounter extends Component
{
    public $products;
    public $selectedProductId;
    public $orderItems = [];
    public $message = '';
    public $pay_money = 0;
    public $balance = 0;
    public $totalAmount = 0;
    public $totalQuantity = 0;
    public $incomingProducts = []; 
    

    public function mount()
    {
        $this->products = Products::all();
        $this->incomingProducts = IncomingProduct::orderBy('batch_date', 'asc')->get(); // Fetch incoming products sorted by date
    }
    public function clearCart()
    {
        $this->orderItems = [];
        $this->totalAmount = 0;
        $this->pay_money = 0;
        $this->balance = 0;
        $this->selectedProductId = null;
    
        // Refresh the product data
        $this->products = Products::all(); // Fetch the latest products
    }
  

    public function addSelectedProductToCart()
    {
        $this->validate([
            'selectedProductId' => 'required',
        ]);
    
        // Fetch the product from the Products table
        $product = Products::where('product_code', $this->selectedProductId)->first();
    
        // Check if the product exists
        if (!$product) {
            session()->flash('error', 'Product not found.');
            return;
        }
    
        // Check current cart quantity
        $cartQuantity = collect($this->orderItems)->where('product_code', $this->selectedProductId)->sum('quantity');
    
        // Calculate total quantity needed
        $desiredQuantity = 1; // Adjust as necessary
        $totalQuantity = $cartQuantity + $desiredQuantity; // Add dollar sign here
    
        // Check if we need to fetch from the IncomingProduct
        if ($product->quantity < $totalQuantity) {
            // Fetch the next batch of IncomingProduct
            $incomingProduct = IncomingProduct::where('product_code', $this->selectedProductId)
                ->orderBy('batch_date', 'asc') // Get the earliest batch first
                ->first();
    
            if ($incomingProduct && $incomingProduct->quantity > 0) {
                // Calculate how much we need from the incoming product
                $neededQuantity = $totalQuantity - $product->quantity; // Add dollar sign here
    
                if ($incomingProduct->quantity >= $neededQuantity) {
                    // Deduct from IncomingProduct
                    $incomingProduct->quantity -= $neededQuantity;
                    $incomingProduct->save();
    
                    // Update the Products quantity
                    $product->quantity += $neededQuantity;
                    $product->save();
    
                    // Add to cart logic
                    $this->addToCart($product, $desiredQuantity);
                } else {
                    session()->flash('error', 'Not enough stock available in the next batch.');
                    return;
                }
            } else {
                session()->flash('error', 'No incoming stock available.');
                return;
            }
        } else {
            // If there's enough stock in the main product table, just add to cart
            $this->addToCart($product, $desiredQuantity);
        }
    
        $this->message = 'Product added to cart!';
    }

private function addToCart($product, $desiredQuantity)
{
    // Add product to orderItems
    $this->orderItems[] = [
        'product_code' => $product->product_code,
        'product_id' => $product->id,
        'product_name' => $product->product_name,
        'selling_price' => $product->selling_price,
        'cost_price' => $product->cost_price,
        'quantity' => $desiredQuantity,
        'total_amount' => $product->selling_price * $desiredQuantity,
    ];
}
    public function decrementQty($index)
    {
        if ($this->orderItems[$index]['quantity'] > 1) {
            $this->orderItems[$index]['quantity']--;
            $this->orderItems[$index]['total_amount'] = $this->orderItems[$index]['selling_price'] * $this->orderItems[$index]['quantity'];
            $this->totalAmount -= $this->orderItems[$index]['selling_price']; // Adjust total amount
        } else {
            session()->flash('error', 'Quantity cannot be less than 1.');
        }
    }

    public function incrementQty($index)
    {
        $item = $this->orderItems[$index];
        $incoming = IncomingProduct::where('product_code', $item['product_code'])->first();
    
        // Check if incrementing exceeds stock
        if ($incoming && ($item['quantity'] + 1) <= $incoming->quantity) {
            $this->orderItems[$index]['quantity']++;
            $this->orderItems[$index]['total_amount'] = $this->orderItems[$index]['selling_price'] * $this->orderItems[$index]['quantity'];
            $this->totalAmount += $item['selling_price']; // Adjust total amount
        } else {
            session()->flash('error', 'Cannot increase quantity. Available stock: ' . ($incoming ? $incoming->quantity : 0));
        }
    }
    // public function savePayment()
    // {
    //     if (!auth()->check()) {
    //         session()->flash('error', 'You need to be logged in to perform this operation.');
    //         return redirect()->route('login');
    //     }
    
    //     $this->validate([
    //         'pay_money' => 'required|numeric|min:0',
    //     ]);
    
    //     $this->balance = $this->pay_money - $this->totalAmount;
    
    //     if ($this->balance < 0) {
    //         session()->flash('error', 'Insufficient payment.');
    //         return;
    //     }
    
    //     DB::transaction(function () {
    //         foreach ($this->orderItems as $item) {
    //             // Fetch the incoming product to update stock
    //             $incomingProduct = IncomingProduct::where('product_code', $item['product_code'])
    //                 ->orderBy('batch_date', 'asc') // Get the earliest batch first
    //                 ->first();
    
    //             if ($incomingProduct) {
    //                 // Ensure stock is sufficient
    //                 if ($incomingProduct->quantity >= $item['quantity']) {
    //                     // Deduct the sold quantity from the stock in IncomingProduct
    //                     $incomingProduct->quantity -= $item['quantity'];
    //                     $incomingProduct->save(); // Save the updated stock
    
    //                     // Update the quantity in Products table
    //                     $product = Products::where('product_code', $item['product_code'])->first();
    //                     if ($product) {
    //                         $product->quantity -= $item['quantity']; // Deduct sold quantity
    //                         $product->save(); // Save the updated product
    //                     }
    
    //                     // Create the sale record
    //                     Sale::create([
    //                         'product_name' => $item['product_name'],
    //                         'product_qty' => $item['quantity'],
    //                         'cost_price' => $item['cost_price'],
    //                         'selling_price' => $item['selling_price'],
    //                         'total_amount' => $this->totalAmount,
    //                         'amount_paid' => $this->pay_money,
    //                         'balance' => $this->balance,
    //                         'method_of_payment' => 'Your Payment Method Here',
    //                         'profit' => ($item['selling_price'] - $item['cost_price']) * $item['quantity'],
    //                         'user_id' => auth()->id(),
    //                         'product_code' => $item['product_code'],
    //                     ]);
    //                 } else {
    //                     session()->flash('error', 'Insufficient stock for ' . $item['product_name']);
    //                     throw new \Exception('Stock insufficient'); // Trigger rollback
    //                 }
    //             }
    //         }
    //     });
    
    //     session()->flash('message', 'Payment successfully recorded.');
    //     $this->clearCart(); // Clear the cart and refresh product data
    //     return redirect()->route('sales.index');
    // }
    public function savePayment()
{
    if (!auth()->check()) {
        session()->flash('error', 'You need to be logged in to perform this operation.');
        return redirect()->route('login');
    }

    $this->validate([
        'pay_money' => 'required|numeric|min:0',
    ]);

    $this->balance = $this->pay_money - $this->totalAmount;

    if ($this->balance < 0) {
        session()->flash('error', 'Insufficient payment.');
        return;
    }

    DB::transaction(function () {
        foreach ($this->orderItems as $item) {
            // Fetch the product to update stock
            $product = Products::where('product_code', $item['product_code'])->first();

            if ($product) {
                // Check if stock is sufficient
                if ($product->quantity >= $item['quantity']) {
                    // Deduct the sold quantity from the Products table
                    $product->quantity -= $item['quantity'];
                    $product->save(); // Save the updated product

                    // Create the sale record
                    Sale::create([
                        'product_name' => $item['product_name'],
                        'product_qty' => $item['quantity'],
                        'cost_price' => $item['cost_price'],
                        'selling_price' => $item['selling_price'],
                        'total_amount' => $this->totalAmount,
                        'amount_paid' => $this->pay_money,
                        'balance' => $this->balance,
                        'method_of_payment' => 'Your Payment Method Here',
                        'profit' => ($item['selling_price'] - $item['cost_price']) * $item['quantity'],
                        'user_id' => auth()->id(),
                        'product_code' => $item['product_code'],
                    ]);
                } else {
                    // If stock is insufficient, check for the next batch
                    $incomingProduct = IncomingProduct::where('product_code', $item['product_code'])
                        ->orderBy('batch_date', 'asc') // Get the earliest batch first
                        ->first();

                    if ($incomingProduct) {
                        // Update the Products table with the next batch quantity
                        $neededQuantity = $item['quantity'] - $product->quantity;
                        if ($incomingProduct->quantity >= $neededQuantity) {
                            // Update stock in IncomingProduct
                            $incomingProduct->quantity -= $neededQuantity;
                            $incomingProduct->save();

                            // Update stock in Products
                            $product->quantity += $neededQuantity;
                            $product->save();

                            // Create the sale record
                            Sale::create([
                                'product_name' => $item['product_name'],
                                'product_qty' => $item['quantity'],
                                'cost_price' => $item['cost_price'],
                                'selling_price' => $item['selling_price'],
                                'total_amount' => $this->totalAmount,
                                'amount_paid' => $this->pay_money,
                                'balance' => $this->balance,
                                'method_of_payment' => 'Your Payment Method Here',
                                'profit' => ($item['selling_price'] - $item['cost_price']) * $item['quantity'],
                                'user_id' => auth()->id(),
                                'product_code' => $item['product_code'],
                            ]);
                        } else {
                            session()->flash('error', 'Insufficient stock for ' . $item['product_name']);
                            throw new \Exception('Stock insufficient'); // Trigger rollback
                        }
                    } else {
                        session()->flash('error', 'Insufficient stock for ' . $item['product_name']);
                        throw new \Exception('Stock insufficient'); // Trigger rollback
                    }
                }
            }
        }
    });

    session()->flash('message', 'Payment successfully recorded.');
    $this->clearCart(); // Clear the cart and refresh product data
    return redirect()->route('sales.index');
}

    public function calculateTotalQuantity($productCode)
    {
        $total = 0;

        foreach ($this->incomingProducts as $incoming) {
            if ($incoming->product_code == $productCode) {
                $total += $incoming->quantity; // Add the quantity from incoming products
            }
        }

        return $total;
    }

    
// public function calculateTotalQuantity($productCode)
// {
//     $total = 0;

//     foreach ($this->incomingProducts as $incoming) {
//         if ($incoming->product_code == $productCode) {
//             $total += $incoming->quantity; // Add the quantity from incoming products
//         }
//     }

//     return $total;
// }
public function getIncomingProductsByCode($productCode)
{
    return IncomingProduct::where('product_code', $productCode)->orderBy('batch_date', 'asc')->get();
}
 


    public function updateTotalAmount($index)
    {
        if (isset($this->orderItems[$index])) {
            $selling_price = $this->orderItems[$index]['selling_price'];
            $quantity = $this->orderItems[$index]['quantity'];

            // Calculate the total amount for this item
            $itemTotal = $selling_price * $quantity;

            // Update the total amount in the component
            $this->orderItems[$index]['total_amount'] = $itemTotal; 
            $this->totalAmount = array_sum(array_column($this->orderItems, 'total_amount')); // Update overall total
            
        }
    }

    

    public function render()
    {
        return view('livewire.payment-counter', [
            'products' => $this->products,
            'orderItems' => $this->orderItems,
            'message' => $this->message,
        ]);
        $this->balance = $totalAmount;

    }
}
