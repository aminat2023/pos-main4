<?php

namespace App\Http\Livewire;

use App\Models\BankTransaction;
use App\Models\CounterSalesDetail;
use App\Models\IncomingStock;
use App\Models\ProductTwo;
use App\Models\TillCollection;
use App\Models\TillWithdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

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
    public $bank_name;
    public $reference;
    public $bankTotal = 0;
    public $selected_bank = '';  // ✅ Add this line
    public $lastReceiptItems = [];
    public $lastPaymentAmount;
    public $lastChange;
    public $recentReceipts = [];
    public $selectedReceipt = null;
    public $selectedReceiptItems = [];
    public $selectedReceiptAmount = 0;
    public $selectedReceiptChange = 0;
    public $searchTerm = '';
    public $searchResults = [];
    

    


    protected $listeners = ['cartUpdated' => 'refreshCart'];

    /* ---------------- lifecycle ---------------- */
    public function mount(): void
    {
        $this->products = ProductTwo::all();
        $this->savedOrders = CounterSalesDetail::latest()->take(10)->get();

        $this->receiptTemplate = DB::table('system_preferences')
            ->where('key', 'receipt_template')
            ->value('value') ?? 'compact58mm';  // fallback

        $cashierId = Auth::id();
        $collected = TillCollection::where('user_id', $cashierId)->where('payment_method', 'cash')->sum('amount');
        $withdrawn = TillWithdrawal::where('cashier_id', $cashierId)->sum('total_amount');
        $this->tillTotal = $collected - $withdrawn;

        $this->bankTotal = BankTransaction::whereDate('date', today())
            ->where('payment_method', 'bank_transfer')
            ->sum('amount');

            $this->loadRecentReceipts();
    }


    public function loadRecentReceipts()
    {
        $this->recentReceipts = CounterSalesDetail::select('id', 'invoice_no', 'amount_paid', 'balance', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get()
            ->unique('invoice_no')
            ->values()
            ->toArray();
    }
    
    public function showReceiptDetails($invoiceId)
    {
        $items = CounterSalesDetail::where('invoice_no', $invoiceId)->get();
    
        $this->selectedReceiptItems = $items->map(function ($item) {
            return [
                'product_name'   => $item->product_name,
                'quantity'       => $item->quantity,
                'selling_price'  => $item->selling_price,
                'discount'       => $item->discount,
                'total_amount'   => $item->total_amount,
            ];
        })->toArray();
    
        if ($items->isNotEmpty()) {
            $this->selectedReceiptAmount = $items->sum('amount_paid');
            $this->selectedReceiptChange = $items->sum('balance');
        } else {
            $this->selectedReceiptAmount = 0;
            $this->selectedReceiptChange = 0;
            $this->errorMessage = "No receipt found for invoice: $invoiceId";
        }
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

    public function save(): void
{
    if (empty($this->orderItems)) {
        $this->errorMessage = 'Cart is empty.';
        return;
    }

    $total = $this->cartTotal();

    // ✅ Prevent underpayment
    if ($this->pay_money < $total) {
        $this->errorMessage = 'Payment is less than the total amount. Please enter the full amount.';
        return;
    }

    DB::beginTransaction();

    try {
        $productsToRefresh = collect($this->orderItems)->pluck('product_code')->unique()->values();
        $totalCashAmount = 0;
        $totalBankAmount = 0;

        $method = strtolower($this->payment_method);
        $userId = Auth::id();

        // ✅ Generate unique invoice number
        $invoiceNo = 'INV-' . now()->format('YmdHis') . '-' . Str::random(4);

        foreach ($this->orderItems as $item) {
            $batch = IncomingStock::where('id', $item['batch_id'])->lockForUpdate()->first();

            if (!$batch || $batch->quantity < $item['quantity']) {
                throw new \Exception("Batch quantity changed for {$item['product_name']}.");
            }

            $batch->quantity -= $item['quantity'];
            $batch->save();

            $profit = ($item['selling_price'] - $item['cost_price']) * $item['quantity'];

            CounterSalesDetail::create([
                'user_id' => $userId,
                'invoice_no' => $invoiceNo, // ✅ Save invoice number here
                'product_code' => $item['product_code'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'cost_price' => $item['cost_price'],
                'selling_price' => $item['selling_price'],
                'total_amount' => $item['total_amount'],
                'amount_paid' => $item['total_amount'],
                'balance' => 0,
                'method_of_payment' => $method,
                'profit' => $profit,
                'discount' => $item['discount'] ?? 0,
            ]);

            if ($method === 'cash') {
                $totalCashAmount += floatval($item['total_amount']);
            } elseif ($method === 'bank_transfer') {
                $totalBankAmount += floatval($item['total_amount']);
            }
        }

        if ($totalCashAmount > 0) {
            TillCollection::create([
                'user_id' => $userId,
                'amount' => round($totalCashAmount, 2),
                'payment_method' => 'cash',
                'date' => now()->toDateString(),
            ]);
        }

        if ($totalBankAmount > 0) {
            BankTransaction::create([
                'user_id' => $userId,
                'amount' => round($totalBankAmount, 2),
                'credit' => round($totalBankAmount, 2),
                'payment_method' => 'bank_transfer',
                'bank_name' => $this->selected_bank,
                'reference' => $this->reference ?? 'BANK-' . now()->timestamp,
                'date' => now()->toDateString(),
            ]);
        }

        foreach ($productsToRefresh as $code) {
            $this->refreshTotalStock($code);
        }

        DB::commit();

        // ✅ Store receipt copy
        $this->lastReceiptItems = $this->orderItems;
        $this->lastPaymentAmount = $this->pay_money;
        $this->lastChange = (float) $this->pay_money - $this->cartTotal();

        // Clear cart
        $this->orderItems = [];
        $this->message = 'Sale saved and stock updated!';
        $this->savedOrders = CounterSalesDetail::latest()->take(10)->get();

        // Update till and bank totals
        $cashierId = Auth::id();
        $totalCollected = TillCollection::where('user_id', $cashierId)->sum('amount');
        $totalWithdrawn = TillWithdrawal::where('cashier_id', $cashierId)->sum('total_amount');
        $this->tillTotal = $totalCollected - $totalWithdrawn;
        $this->bankTotal = BankTransaction::where('user_id', $cashierId)->sum('amount');

        // Trigger print
        $this->dispatchBrowserEvent('printReceipt');
    } catch (\Throwable $e) {
        DB::rollBack();
        $this->errorMessage = 'Could not save sale: ' . $e->getMessage();
    }
}


    public function loadInvoice($invoiceNumber)
    {
        $items = CounterSalesDetail::where('invoice_number', $invoiceNumber)->get();

        $this->lastReceiptItems = $items->map(function ($item) {
            return [
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'selling_price' => $item->selling_price,
                'total_amount' => $item->total_amount
            ];
        })->toArray();

        $this->lastPaymentAmount = $items->sum('amount_paid');
        $this->lastChange = 0;

        $this->dispatchBrowserEvent('printReceipt');  // Trigger re-print
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

    function getPreference($key, $default = null)
    {
        $value = \App\Models\SystemPreference::where('key', $key)->value('value');

        // If it's a JSON array (like for banks), decode it
        if (is_string($value) && is_array(json_decode($value, true))) {
            return json_decode($value, true);
        }

        return $value ?? $default;
    }

    public function processPayment()
    {
        if ($this->payment_method === 'bank_transfer' && empty($this->selected_bank)) {
            session()->flash('error', 'Please select a bank.');
            return;
        }

        // Use $this->selected_bank in your transaction save logic
    }


    public function updatedSearchTerm()
    {
        $this->searchResults = ProductTwo::where('product_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('product_code', 'like', '%' . $this->searchTerm . '%')
            ->limit(10)
            ->get()
            ->toArray();
    }
    
public function selectProduct($productId)
{
    $this->selectedProductId = $productId;
    $this->addSelectedProductToCart($productId); // ✅ Pass productId into the method
    $this->reset(['searchTerm', 'searchResults']); // ✅ Clear search UI
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
