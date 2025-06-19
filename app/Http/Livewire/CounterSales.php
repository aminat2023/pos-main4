<?php

namespace App\Http\Livewire;

use App\Models\CounterSalesDetail;
use App\Models\IncomingStock;
use App\Models\ProductTwo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\TillCollection;

class CounterSales extends Component
{
    /* ---------------- public state ---------------- */
    public $orderItems = [];  // cart rows
    public $products;
    public $selectedProductId;
    public $pay_money;
    public $balance;
    public $payment_method = 'cash';
    public $message = '';  // green info
    public $errorMessage = '';  // red error
    public $savedOrders = [];  // last 10 saved
    public $cashCollections = [];
    public $newCash;
    public $tillTotal = 0;
    public $receiptTemplate = 'compact58mm';  // default fallback

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    /* ---------------- lifecycle ---------------- */
    public function mount(): void
    {
        $this->products = ProductTwo::all();
        $this->savedOrders = CounterSalesDetail::latest()->take(10)->get();

        $this->receiptTemplate = DB::table('system_preferences')
            ->where('key', 'receipt_template')
            ->value('value') ?? 'compact58mm';  // fallback

            $this->tillTotal = TillCollection::whereDate('date', today())
            ->where('payment_method', 'cash')
            ->sum('amount');
    }

    /* ---------------- helpers ---------------- */
    private function cartTotal(): float
    {
        return array_sum(array_column($this->orderItems, 'total_amount'));
    }

    /* ---------------- select hook -------------- */
    public function updatedSelectedProductId($value): void
    {
        if ($value)
            $this->addSelectedProductToCart((int) $value);
    }

    /* ------------- ADD TO CART (no DB write) ------------- */
    public function addSelectedProductToCart(int $productId): void
    {
        if (!Auth::check()) {
            $this->errorMessage = 'You need to login first.';
            return;
        }

        $product = ProductTwo::find($productId);
        if (!$product) {
            $this->errorMessage = 'Product not found.';
            return;
        }

        $unitsToSell = 1;
        $this->message = '';

        $batches = IncomingStock::where('product_code', $product->product_code)
            ->orderBy('batch_date')
            ->get();

        if ($batches->isEmpty()) {
            $this->errorMessage = 'No stock available.';
            return;
        }

        foreach ($batches as $batch) {
            if ($unitsToSell === 0)
                break;
            if ($batch->quantity === 0)
                continue;

            $reserved = collect($this->orderItems)
                ->where('batch_id', $batch->id)
                ->sum('quantity');

            $freeQty = $batch->quantity - $reserved;
            if ($freeQty <= 0)
                continue;

            $take = min($freeQty, $unitsToSell);

            $idx = collect($this->orderItems)->search(fn($row) =>
                $row['batch_id'] == $batch->id);

            if ($idx !== false) {
                $this->orderItems[$idx]['quantity'] += $take;
                $this->orderItems[$idx]['total_amount'] = $this->orderItems[$idx]['quantity'] * $this->orderItems[$idx]['selling_price'];
                $this->orderItems[$idx]['profit'] = ($batch->selling_price - $batch->cost_price) * $this->orderItems[$idx]['quantity'];
            } else {
                $this->orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'product_code' => $product->product_code,
                    'batch_id' => $batch->id,
                    'batch_date' => $batch->batch_date,
                    'quantity' => $take,
                    'cost_price' => $batch->cost_price,
                    'selling_price' => $batch->selling_price,
                    'total_amount' => $batch->selling_price * $take,
                    'profit' => ($batch->selling_price - $batch->cost_price) * $take,
                    'discount' => 0,
                    'max_quantity' => $batch->quantity,
                ];
            }

            $formatted = \Carbon\Carbon::parse($batch->batch_date)->format('Y-m-d');
            $this->message .= "Reserved {$take} unit(s) of '{$product->product_name}' from batch {$formatted}.\n";

            $unitsToSell -= $take;
        }

        if ($unitsToSell > 0) {
            $this->errorMessage = 'Not enough free stock.';
        }

        $this->selectedProductId = null;  // 👈 reset for re-selection
        $this->dispatchBrowserEvent('cartUpdated');
    }

    /* ------------- QUANTITY ADJUSTMENT ------------- */
    public function incrementQty(int $index): void
    {
        $row = &$this->orderItems[$index];
        if ($row['quantity'] >= $row['max_quantity'])
            return;

        $row['quantity'] += 1;
        $row['total_amount'] = $row['quantity'] * $row['selling_price'];
        $row['profit'] = ($row['selling_price'] - $row['cost_price']) * $row['quantity'];
        $this->dispatchBrowserEvent('cartUpdated');
    }

    public function decrementQty(int $index): void
    {
        $row = &$this->orderItems[$index];
        if ($row['quantity'] <= 1)
            return;

        $row['quantity'] -= 1;
        $row['total_amount'] = $row['quantity'] * $row['selling_price'];
        $row['profit'] = ($row['selling_price'] - $row['cost_price']) * $row['quantity'];
        $this->dispatchBrowserEvent('cartUpdated');
    }

    /* ------------- REMOVE ROW ------------- */
    public function removeRow(int $index): void
    {
        unset($this->orderItems[$index]);
        $this->orderItems = array_values($this->orderItems);
    }

    // public function save(): void
    // {
    //     if (!$this->orderItems) {
    //         $this->errorMessage = 'Cart is empty.';
    //         return;
    //     }

    //     DB::beginTransaction();
    //     try {
    //         /* We may touch multiple product codes; gather unique ones to refresh totals later */
    //         $productsToRefresh = collect($this->orderItems)->pluck('product_code')->unique()->values();

    //         foreach ($this->orderItems as $item) {
    //             $batch = IncomingStock::where('id', $item['batch_id'])
    //                 ->lockForUpdate()
    //                 ->first();

    //             if (!$batch || $batch->quantity < $item['quantity']) {
    //                 throw new \Exception("Batch quantity changed for {$item['product_name']}.");
    //             }

    //             $batch->quantity -= $item['quantity'];
    //             $batch->save();

    //             CounterSalesDetail::create([
    //                 'user_id' => Auth::id(),
    //                 'product_code' => $item['product_code'],
    //                 'product_name' => $item['product_name'],
    //                 'quantity' => $item['quantity'],
    //                 'cost_price' => $item['cost_price'],
    //                 'selling_price' => $item['selling_price'],
    //                 'total_amount' => $item['total_amount'],
    //                 'amount_paid' => $item['total_amount'],
    //                 'balance' => 0,
    //                 'method_of_payment' => 'Cash',
    //                 'profit' => $item['profit'],
    //             ]);
    //         }

    //         /* update total_stock for each product we touched */
    //         foreach ($productsToRefresh as $code) {
    //             $this->refreshTotalStock($code);
    //         }

    //         DB::commit();
    //         $this->orderItems = [];
    //         $this->message = 'Sale saved and stock updated!';
    //         $this->savedOrders = CounterSalesDetail::latest()->take(10)->get();
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Save sale error: ' . $e->getMessage());
    //         $this->errorMessage = 'Could not save sale.';
    //     }
    // }

    // public function save(): void
    // {
    //     if (!$this->orderItems) {
    //         $this->errorMessage = 'Cart is empty.';
    //         return;
    //     }
    
    //     DB::beginTransaction();
    //     try {
    //         $productsToRefresh = collect($this->orderItems)->pluck('product_code')->unique()->values();
    //         $totalCashAmount = 0;
    
    //         foreach ($this->orderItems as $item) {
    //             $batch = IncomingStock::where('id', $item['batch_id'])
    //                      ->lockForUpdate()->first();
    
    //             if (!$batch || $batch->quantity < $item['quantity']) {
    //                 throw new \Exception("Batch quantity changed for {$item['product_name']}.");
    //             }
    
    //             $batch->quantity -= $item['quantity'];
    //             $batch->save();
    
    //             CounterSalesDetail::create([
    //                 'user_id'           => Auth::id(),
    //                 'product_code'      => $item['product_code'],
    //                 'product_name'      => $item['product_name'],
    //                 'quantity'          => $item['quantity'],
    //                 'cost_price'        => $item['cost_price'],
    //                 'selling_price'     => $item['selling_price'],
    //                 'total_amount'      => $item['total_amount'],
    //                 'amount_paid'       => $item['total_amount'],
    //                 'balance'           => 0,
    //                 'method_of_payment' => $this->payment_method,
    //                 'profit'            => $item['profit'],
    //             ]);
    
    //             // If payment is cash, accumulate amount
    //             if (strtolower($this->payment_method) === 'cash') {
    //                 $totalCashAmount += floatval($item['total_amount']);
    //             }
    //         }
    
    //         // Update the till only once after loop
    //         if (strtolower($this->payment_method) === 'cash') {
    //             $this->tillTotal += $totalCashAmount;
    //         }
    
    //         foreach ($productsToRefresh as $code) {
    //             $this->refreshTotalStock($code);
    //         }
    
    //         DB::commit();
    //         $this->orderItems  = [];
    //         $this->message     = 'Sale saved and stock updated!';
    //         $this->savedOrders = CounterSalesDetail::latest()->take(10)->get();
    
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Save sale error: ' . $e->getMessage());
    //         $this->errorMessage = 'Could not save sale.';
    //     }
    // }
    public function save(): void
{
    if (!$this->orderItems) {
        $this->errorMessage = 'Cart is empty.';
        return;
    }

    DB::beginTransaction();
    try {
        $productsToRefresh = collect($this->orderItems)->pluck('product_code')->unique()->values();
        $totalCashAmount = 0;

        foreach ($this->orderItems as $item) {
            $batch = IncomingStock::where('id', $item['batch_id'])->lockForUpdate()->first();

            if (!$batch || $batch->quantity < $item['quantity']) {
                throw new \Exception("Batch quantity changed for {$item['product_name']}.");
            }

            $batch->quantity -= $item['quantity'];
            $batch->save();

            CounterSalesDetail::create([
                'user_id'           => Auth::id(),
                'product_code'      => $item['product_code'],
                'product_name'      => $item['product_name'],
                'quantity'          => $item['quantity'],
                'cost_price'        => $item['cost_price'],
                'selling_price'     => $item['selling_price'],
                'total_amount'      => $item['total_amount'],
                'amount_paid'       => $item['total_amount'],
                'balance'           => 0,
                'method_of_payment' => $this->payment_method,
                'profit'            => $item['profit'],
            ]);

            // If payment is cash, add to total cash
            if (strtolower($this->payment_method) === 'cash') {
                $totalCashAmount += floatval($item['total_amount']);
            }
        }

        // If payment is cash, insert into till_collections
        if ($totalCashAmount > 0) {
            TillCollection::create([
                'user_id'        => Auth::id(),
                'amount'         => round($totalCashAmount, 2),
                'payment_method' => 'cash',
                'date'           => now()->toDateString(),
            ]);
        }

        // Update stock levels
        foreach ($productsToRefresh as $code) {
            $this->refreshTotalStock($code);
        }

        DB::commit();

        // Clear the cart
        $this->orderItems = [];
        $this->message = 'Sale saved and stock updated!';
        $this->savedOrders = CounterSalesDetail::latest()->take(10)->get();

        // Refresh tillTotal for today
        $this->tillTotal = TillCollection::whereDate('date', today())
                                         ->where('payment_method', 'cash')
                                         ->sum('amount');
    } catch (\Throwable $e) {
        DB::rollBack();
        $this->errorMessage = 'Could not save sale: ' . $e->getMessage();
    }
}



    private function refreshTotalStock(string $productCode): void
    {
        $total = IncomingStock::where('product_code', $productCode)->sum('quantity');
        IncomingStock::where('product_code', $productCode)->update(['total_stock' => $total]);
    }

    public function addCashToTill()
    {
        $amount = floatval($this->newCash);

        if ($amount > 0) {
            $this->cashCollections[] = $amount;
            $this->newCash = null;  // Clear input after adding
        }
    }

    public function getTillTotalProperty()
{
    return collect($this->cashCollections)->sum();
}


    /* ------------- render ------------- */
    public function render()
    {
        $this->balance = (float) $this->pay_money - $this->cartTotal();

        return view('livewire.counter-sales', [
            'receiptTemplate' => $this->receiptTemplate
        ]);
    }

    public function refreshCart(): void {}
}
