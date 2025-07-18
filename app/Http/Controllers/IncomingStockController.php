<?php

namespace App\Http\Controllers;

use App\Models\IncomingStock;
use App\Models\ProductTwo;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OpeningStockImport;




class IncomingStockController extends Controller
{
   
    public function index()
    {
        $products = ProductTwo::all();
    
        $totalProducts = ProductTwo::count();
        $totalQuantity = IncomingStock::sum('quantity');
        $totalPending  = Supply::where('already_imported', false)->count();
    
        $recentStocks = IncomingStock::with('product')
                        ->latest()
                        ->take(5)
                        ->get();
    
        return view('incoming_stock.index', compact(
            'products',
            'totalProducts',
            'totalQuantity',
            'totalPending',
            'recentStocks'
        ));
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
    // ✅ Only get supplies that haven't been imported yet
    $supplies = Supply::where('already_imported', false)->orderBy('created_at')->get();

    return view('incoming_stock.review_batch', compact('supplies'));
}


// public function submitBatch(Request $request)
// {
//     $data = $request->input('stocks', []);

//     foreach ($data as $item) {
//         if (
//             empty($item['id']) || empty($item['product_name']) || 
//             empty($item['quantity']) || empty($item['cost_price']) || 
//             empty($item['selling_price'])
//         ) {
//             continue;
//         }

//         $product = ProductTwo::where('product_name', $item['product_name'])->first();
//         if (!$product) continue;

//         $totalStock = IncomingStock::where('product_code', $product->product_code)->sum('quantity') + $item['quantity'];

//         IncomingStock::create([
//             'product_code'   => $product->product_code,
//             'product_name'   => $item['product_name'],
//             'quantity'       => $item['quantity'],
//             'cost_price'     => $item['cost_price'],
//             'selling_price'  => $item['selling_price'],
//             'total_stock'    => $totalStock,
//             'batch_date'     => now(),
//         ]);

//         // ✅ Remove the imported supply
//         Supply::where('id', $item['id'])->delete();
//     }

//     return redirect()->route('incoming_stock.review_batch')->with('success', 'Imported supplies saved and removed from the table.');
// }




// public function importOpeningStock(Request $request)
// {
//     $request->validate([
//         'stock_file' => 'required|mimes:xlsx,xls,csv',
//     ]);

//     $file = $request->file('stock_file');
//     $data = Excel::toArray([], $file)[0]; // get first sheet

//     $header = array_map('strtolower', array_map('trim', $data[0]));
//     unset($data[0]); // remove header row

//     foreach ($data as $row) {
//         $row = array_combine($header, $row);
//         if (!$row || !isset($row['product_name'], $row['quantity'], $row['cost_price'], $row['selling_price'])) {
//             continue;
//         }

//         // ✅ Generate product code
//         $code = strtoupper(Str::random(8));

//         // ✅ Insert product
//         $product = ProductTwo::create([
//             'product_code'    => $code,
//             'product_name'    => $row['product_name'],
//             'section_name'    => $row['section'] ?? 'General',
//             'category_name'   => $row['category'] ?? 'Uncategorized',
//             'cost_price'      => $row['cost_price'],
//             'selling_price'   => $row['selling_price'],
//         ]);
        
//         // ✅ Insert stock
//         $stockQty = (int) $row['quantity'];
//         IncomingStock::create([
//             'product_code'    => $code,
//             'product_name'    => $row['product_name'],
//             'quantity'        => $stockQty,
//             'cost_price'      => $row['cost_price'],
//             'selling_price'   => $row['selling_price'],
//             'section_name'    => $row['section'] ?? 'General',
//             'category_name'   => $row['category'] ?? 'Uncategorized',
//             'total_stock'     => $stockQty,
//             'batch_date'      => now(),
//         ]);
        
//     }

//     return redirect()->route('opening_stock.import_form')->with('success', 'Opening stock imported successfully!');
// }

public function importOpeningStock(Request $request)
{
    $request->validate([
        'stock_file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max
    ]);

    $file = $request->file('stock_file');

    try {
        $rows = Excel::toArray([], $file)[0];

        if (empty($rows) || count($rows) < 2) {
            return back()->with('error', 'Excel file is empty or missing data.');
        }

        // Normalize header
        $header = array_map(fn($h) => strtolower(trim($h)), $rows[0]);
        unset($rows[0]);

        $count = 0;

        foreach ($rows as $row) {
            $row = array_combine($header, $row);

            if (
                !$row ||
                empty($row['product_name']) ||
                !is_numeric($row['quantity']) ||
                !is_numeric($row['cost_price']) ||
                !is_numeric($row['selling_price'])
            ) {
                continue;
            }

            $code = strtoupper(Str::random(8));
            $qty  = (int) $row['quantity'];

            // Save product
            ProductTwo::create([
                'product_code'   => $code,
                'product_name'   => $row['product_name'],
                'section_name'   => $row['section'] ?? 'General',
                'category_name'  => $row['category'] ?? 'Uncategorized',
                'cost_price'     => $row['cost_price'],
                'selling_price'  => $row['selling_price'],
            ]);

            // Save stock
            IncomingStock::create([
                'product_code'   => $code,
                'product_name'   => $row['product_name'],
                'quantity'       => $qty,
                'cost_price'     => $row['cost_price'],
                'selling_price'  => $row['selling_price'],
                'section_name'   => $row['section'] ?? 'General',
                'category_name'  => $row['category'] ?? 'Uncategorized',
                'total_stock'    => $qty,
                'batch_date'     => now(),
            ]);

            $count++;
        }

        return redirect()->route('opening_stock.import_form')
            ->with('success', "Imported $count product(s) successfully.");

    } catch (\Exception $e) {
        return back()->with('error', 'Error processing file: ' . $e->getMessage());
    }
}


public function showImportForm()
{
    return view('opening_stock.import');
}

public function handleImport(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new OpeningStockImport, $request->file('file'));

    return redirect()->back()->with('success', 'Opening stock imported successfully!');
}

public function showManualForm()
{
    return view('opening_stock.manual');
}

public function storeManual(Request $request)
{
    $request->validate([
        'product_name'   => 'required|string',
        'section'        => 'nullable|string',
        'category'       => 'nullable|string',
        'quantity'       => 'required|integer|min:1',
        'cost_price'     => 'required|numeric|min:0',
        'selling_price'  => 'required|numeric|min:0|gt:cost_price',
    ]);

    $code = strtoupper(Str::random(8));

    // Save Product
    ProductTwo::create([
        'product_code'   => $code,
        'product_name'   => $request->product_name,
        'section'        => $request->section ?? 'General',
        'category'       => $request->category ?? 'Uncategorized',
        'cost_price'     => $request->cost_price,
        'selling_price'  => $request->selling_price,
    ]);

    // Save Stock
    IncomingStock::create([
        'product_code'   => $code,
        'product_name'   => $request->product_name,
        'quantity'       => $request->quantity,
        'cost_price'     => $request->cost_price,
        'selling_price'  => $request->selling_price,
        'total_stock'    => $request->quantity,
        'batch_date'     => now(),
    ]);

    return redirect()->route('opening_stock.manual_form')->with('success', 'Product and opening stock saved successfully!');
}



// IncomingStockController.php

public function submitBatch(Request $request)
{
    $stocks = $request->input('stocks', []);

    foreach ($stocks as $stock) {
        if (!isset($stock['product_name'], $stock['quantity'], $stock['cost_price'], $stock['selling_price'])) {
            continue;
        }

        $product = ProductTwo::where('product_name', $stock['product_name'])->first();
        if (!$product) continue;

        // Save incoming stock
        IncomingStock::create([
            'product_code'   => $product->product_code,
            'product_name'   => $product->product_name,
            'quantity'       => $stock['quantity'],
            'cost_price'     => $stock['cost_price'],
            'selling_price'  => $stock['selling_price'],
            'total_stock'    => $stock['quantity'], // optional but helpful
            'batch_date'     => now(),
        ]);

        // ✅ Mark only the first matching unimported record
        Supply::where('product_name', $stock['product_name'])
            ->where('quantity', $stock['quantity'])
            ->where('unit_price', $stock['cost_price'])
            ->where('already_imported', false)
            ->orderBy('id')
            ->limit(1)
            ->update(['already_imported' => true]);
    }

    return redirect()->route('incoming_stock.review_batch')
                     ->with('success', 'All selected supplies have been imported successfully!');
}






   
    
    
}