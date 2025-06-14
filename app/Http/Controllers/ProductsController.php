<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\IncomingProduct;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Products::paginate(10); // Paginate products
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        // You can return a view for creating a new product if needed
    }



    // Store a newly created product in storage
//     public function store(Request $request)
// {
//     // Validate the incoming request
//     $request->validate([
//         'product_name' => 'required|string|max:255',
//         'brand' => 'required|string|max:255',
//         'alert_stock' => 'required|integer|min:0',
//         'description' => 'required|string',
//         'cost_price' => 'required|numeric|min:0',
//         'selling_price' => 'required|numeric|min:0',
//         'quantity' => 'required|integer|min:0',
//         'product_image' => 'nullable|image|max:2048',
//     ]);

//     $product = new Products();
    
//     // Generate a FIFO product code
//     $lastProduct = Products::orderBy('created_at', 'asc')->first();
//     $nextCode = $lastProduct ? intval(substr($lastProduct->product_code, -4)) + 1 : 1; // Increment last code
//     $product_code = 'PROD-' . str_pad($nextCode, 4, '0', STR_PAD_LEFT); // Format: PROD-0001
//     $product->product_code = $product_code; // Assign the generated code

//     // Handle product image upload
//     if ($request->hasFile('product_image')) {
//         $file = $request->file('product_image');
//         $product_image = $file->getClientOriginalName();
//         $file->move(public_path('products/images'), $product_image);
//         $product->product_image = $product_image;
//     }

//     // Store product details
//     $product->fill($request->only([
//         'product_name', 'description', 'brand', 'cost_price', 'selling_price', 'alert_stock', 'quantity'
//     ]));
//     $product->save();

//     return redirect()->route('product.index')->with('success', 'Product created successfully');
// }


// public function store(Request $request)
// {
//     // Validate the incoming request
//     $request->validate([
//         'product_name' => 'required|string|max:255',
//         'brand' => 'required|string|max:255',
//         'alert_stock' => 'required|integer|min:0',
//         'description' => 'required|string',
//         'cost_price' => 'required|numeric|min:0',
//         'selling_price' => 'required|numeric|min:0',
//         'quantity' => 'required|integer|min:0',
//         'product_image' => 'nullable|image|max:2048',
//         'batch_date' => 'required|date', // Validate batch date
//     ]);

//     $product = new Products();

//     // Generate a unique product code
//     do {
//         $lastProduct = Products::orderBy('created_at', 'desc')->first();
//         $nextCode = $lastProduct ? intval(substr($lastProduct->product_code, -4)) + 1 : 1; // Increment last code
//         $product_code = 'PROD-' . str_pad($nextCode, 4, '0', STR_PAD_LEFT); // Format: PROD-0001
//     } while (Products::where('product_code', $product_code)->exists()); // Ensure uniqueness

//     $product->product_code = $product_code; // Assign the generated code

//     // Handle product image upload
//     if ($request->hasFile('product_image')) {
//         $file = $request->file('product_image');
//         $product_image = $file->getClientOriginalName();
//         $file->move(public_path('products/images'), $product_image);
//         $product->product_image = $product_image;
//     }

//     // Store product details including batch date
//     $product->fill($request->only([
//         'product_name', 'description', 'brand', 'cost_price', 'selling_price', 'alert_stock', 'quantity', 'batch_date'
//     ]));
//     $product->save();

//     // Save to incoming_products table
//     $incomingProduct = new IncomingProduct();
//     $incomingProduct->product_code = $product_code; // Use the generated product code
//     $incomingProduct->quantity = $request->quantity; // Use the quantity from the request
//     $incomingProduct->product_code = $request->product_code; // Save the batch date
//     $incomingProduct->save();

//     // Calculate total incoming quantity for the product_code
//     $totalIncomingQuantity = IncomingProduct::where('product_code', $product_code)->sum('quantity');

//     // Update the products table with the total incoming quantity
//     $product->quantity = $totalIncomingQuantity; // Set the quantity to the total incoming quantity
//     $product->save();

//     return redirect()->route('product.index')->with('success', 'Product created successfully');
// }
public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'product_name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'alert_stock' => 'required|integer|min:0',
        'description' => 'required|string',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'product_image' => 'nullable|image|max:2048',
    ]);

    $product = new Products();

    // Generate a unique product code
    do {
        $lastProduct = Products::orderBy('created_at', 'desc')->first();
        $nextCode = $lastProduct ? intval(substr($lastProduct->product_code, -4)) + 1 : 1; // Increment last code
        $product_code = 'PROD-' . str_pad($nextCode, 4, '0', STR_PAD_LEFT); // Format: PROD-0001
    } while (Products::where('product_code', $product_code)->exists()); // Ensure uniqueness

    $product->product_code = $product_code; // Assign the generated code

    // Handle product image upload
    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        $product_image = $file->getClientOriginalName();
        $file->move(public_path('products/images'), $product_image);
        $product->product_image = $product_image;
    }

    // Set the batch date to the current date
    $product->batch_date = now(); // Automatically set the batch date to now

    // Store product details
    $product->fill($request->only([
        'product_name', 'description', 'brand', 'cost_price', 'selling_price', 'alert_stock', 'quantity'
    ]));
    $product->save();

    // Save to incoming_products table
    $incomingProduct = new IncomingProduct();
    $incomingProduct->product_code = $product_code; // Use the generated product code
    $incomingProduct->product_name = $request->product_name; // Use the quantity from the request
    $incomingProduct->quantity = $request->quantity; // Use the quantity from the request
    $incomingProduct->cost_price = $request->cost_price; // Set cost price
    $incomingProduct->selling_price = $request->selling_price; // Set selling price
    $incomingProduct->batch_date = $product->batch_date; // Set batch date from the product
    $incomingProduct->save();

    // Calculate total incoming quantity for the product_code
    $totalIncomingQuantity = IncomingProduct::where('product_code', $product_code)->sum('quantity');

    // Update the products table with the total incoming quantity
    $product->quantity = $totalIncomingQuantity; // Set the quantity to the total incoming quantity
    $product->save();

    return redirect()->route('product.index')->with('success', 'Product created successfully');
}



    
    // Display the specified product
    public function show($id)
    {
        $product = Products::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage
    // public function update(Request $request, $id)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'product_name' => 'required|string|max:255',
    //         'brand' => 'required|string|max:255',
    //         'alert_stock' => 'required|integer|min:0',
    //         'description' => 'required|string',
    //         'cost_price' => 'required|numeric|min:0',
    //         'selling_price' => 'required|numeric|min:0',
    //         'quantity' => 'required|integer|min:0',
    //         'product_image' => 'nullable|image|max:2048',
    //     ]);
    
    //     $product = Products::findOrFail($id);
    
    //     // Handle product image upload
    //     if ($request->hasFile('product_image')) {
    //         $this->deleteOldImage($product); // Delete old image if exists
    //         $file = $request->file('product_image');
    //         $product_image = time() . '_' . $file->getClientOriginalName(); // Unique name
    //         $file->move(public_path('products/images'), $product_image);
    //         $product->product_image = $product_image;
    //     }
    
    //     // Update product details, but keep the product_code unchanged
    //     $product->fill($request->only([
    //         'product_name', 'description', 'brand', 'cost_price', 'selling_price', 'alert_stock', 'quantity'
    //     ]));
    //     $product->save();
    
    //     return redirect()->route('product.index')->with('success', 'Product updated successfully');
    // }
    public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'product_name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'alert_stock' => 'required|integer|min:0',
        'description' => 'required|string',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'product_image' => 'nullable|image|max:2048',
        'batch_date' => 'required|date', // Validate batch date
    ]);

    $product = Products::findOrFail($id);

    // Handle product image upload
    if ($request->hasFile('product_image')) {
        $this->deleteOldImage($product); // Delete old image if exists
        $file = $request->file('product_image');
        $product_image = time() . '_' . $file->getClientOriginalName(); // Unique name
        $file->move(public_path('products/images'), $product_image);
        $product->product_image = $product_image;
    }

    // Update product details, including batch date
    $product->fill($request->only([
        'product_name', 'description', 'brand', 'cost_price', 'selling_price', 'alert_stock', 'quantity', 'batch_date'
    ]));
    $product->save();

    return redirect()->route('product.index')->with('success', 'Product updated successfully');
}

    

    // Remove the specified product from storage
    public function destroy($product_code)
    {
        try {
            // Find the product by its code
            $product = Products::where('product_code', $product_code)->firstOrFail();
            
            // Clean up the old image if it exists
            $this->deleteOldImage($product);
            
            // Delete incoming products associated with this product code
            IncomingProduct::where('product_code', $product_code)->delete();
            
            // Delete the product
            $product->delete();
    
            // Redirect with a success message
            return redirect()->route('product.index')->with('success', 'Product and associated incoming products deleted successfully');
        } catch (ModelNotFoundException $e) {
            // Handle case where the product is not found
            return redirect()->route('product.index')->with('error', 'Product not found');
        } catch (\Exception $e) {
            // Handle any other exceptions
            return redirect()->route('product.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    
    // Delete old product image
    private function deleteOldImage($product)
    {
        $imagePath = public_path('products/images/' . $product->product_image);
        
        // Check if the product has an image and if the file exists
        if ($product->product_image && file_exists($imagePath)) {
            unlink($imagePath); // Delete old image
        }
    }
    



    public function fetchProductName($id)
    {
        $product = Products::find($id); // Fetch the product by ID

        if ($product) {
            return response()->json([
                'success' => true,
                'product_name' => $product->product_name, // Adjust based on your Product model
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }
    }
    // public function addIncomingProduct(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'product_code' => 'required|string', // Ensure product_code is provided
    //         'quantity' => 'required|integer|min:1', // Ensure quantity is valid
    //     ]);
    
    //     // Create a new incoming product entry
    //     $incomingProduct = new IncomingProduct();
    //     $incomingProduct->product_code = $request->product_code; // Use product_code
    //     $incomingProduct->quantity = $request->quantity;
    //     $incomingProduct->save();
    
    //     // Update the existing product stock
    //     $product = Products::where('product_code', $request->product_code)->first(); // Use the correct column name
    //     if (!$product) {
    //         return redirect()->back()->with('error', 'Product not found.');
    //     }
    //     $product->quantity += $request->quantity;// Assuming 'stock' is a field in the products table
    //     $product->save();
    
    //     return redirect()->back()->with('success', 'Incoming product batch added successfully!');
    // }
    public function addIncomingProduct(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_code' => 'required|string',
            'product_name' => 'required|string', // Ensure product_name is validated
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'batch_date' => 'required|date',
        ]);
    
        // Create a new incoming product entry
        $incomingProduct = new IncomingProduct();
        $incomingProduct->product_code = $request->product_code;
        $incomingProduct->product_name = $request->product_name; // This should now have a value
        $incomingProduct->quantity = $request->quantity;
        $incomingProduct->cost_price = $request->cost_price; // Set cost price
        $incomingProduct->selling_price = $request->selling_price; // Set selling price
        $incomingProduct->batch_date = $request->batch_date; // Set batch date
        $incomingProduct->save();
    
        // Update the existing product stock
        $product = Products::where('product_code', $request->product_code)->first();
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $product->quantity += $request->quantity;
        $product->save();
    
        return redirect()->back()->with('success', 'Incoming product batch added successfully!');
    }
    
    



public function editIncomingProduct($id)
{
 $incomingProduct = IncomingProduct::find($id);
 return view('incoming-product.edit', compact('incomingProduct'));
}
public function updateIncomingProduct(Request $request, $id)
{
 $incomingProduct = IncomingProduct::find($id);
 $incomingProduct->update($request->all());
 return redirect()->route('incoming-product.index');
}
public function deleteIncomingProduct($id)
{
 $incomingProduct = IncomingProduct::find($id);
 $incomingProduct->delete();
 return redirect()->route('incoming-product.index');
}



    
}




