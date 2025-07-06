<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\IncomingStock;
use App\Models\ProductTwo;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductTwoController extends Controller
{
    /* --------------------------------------------------------------------
     | INDEX
     |-------------------------------------------------------------------*/
    public function index()
    {
        $products   = ProductTwo::paginate(10);
        $sections   = Section::all();      // for dropdowns
        $categories = Category::all();     // for dropdowns

        return view('products_two.index', compact('products', 'sections', 'categories'));
    }

    /* --------------------------------------------------------------------
     | CREATE VIEW
     |-------------------------------------------------------------------*/
    public function create()
    {
        return view('products_two.create');
    }

    /* --------------------------------------------------------------------
     | STORE  (section_id / category_id -> names)
     |-------------------------------------------------------------------*/
     public function store(Request $request)
     {
         $request->validate([
             'product_name'  => 'required|string|max:255',
             'brand'         => 'nullable|string|max:255',
             'description'   => 'required|string',
             'alert_stock'   => 'required|integer|min:0',
             'barcode'       => 'nullable|string|max:255',
             'qrcode'        => 'nullable|string|max:255',
             'product_image' => 'nullable|image|max:2048',
             'section_id'    => 'required|exists:sections,id',
             'category_id'   => 'required|exists:categories,id',
         ]);
     
         /* -------- generate product code using ID -------- */
         $maxId = ProductTwo::max('id') + 1;
         $code = 'PROD-' . str_pad($maxId, 4, '0', STR_PAD_LEFT);
     
         /* -------- make new product -------- */
         $product = new ProductTwo([
             'product_code' => $code,
             'product_name' => $request->product_name,
             'description'  => $request->description,
             'brand'        => $request->brand,
             'alert_stock'  => $request->alert_stock,
             'barcode'      => $request->barcode,
             'qrcode'       => $request->qrcode,
             'batch_date'   => now(),
         ]);
     
         /* -------- upload image if present -------- */
         if ($request->hasFile('product_image')) {
             $fileName = time() . '_' . $request->file('product_image')->getClientOriginalName();
             $request->file('product_image')->move(public_path('products/images'), $fileName);
             $product->product_image = $fileName;
         }
     
         /* -------- translate IDs to names -------- */
         $product->section_name  = Section::findOrFail($request->section_id)->section_name;
         $product->category_name = Category::findOrFail($request->category_id)->category_name;
     
         $product->save();
     
         return redirect()->route('products_two.index')
                          ->with('success', 'Product created successfully');
     }
     

    /* --------------------------------------------------------------------
     | SHOW
     |-------------------------------------------------------------------*/
    public function show($id)
    {
        $product = ProductTwo::findOrFail($id);
        return view('products_two.show', compact('product'));
    }

    /* --------------------------------------------------------------------
     | EDIT VIEW
     |-------------------------------------------------------------------*/
    public function edit($id)
    {
        $product    = ProductTwo::findOrFail($id);
        $sections   = Section::all();
        $categories = Category::all();

        return view('products_two.edit', compact('product', 'sections', 'categories'));
    }

    /* --------------------------------------------------------------------
     | UPDATE  (section_id / category_id -> names)
     |-------------------------------------------------------------------*/
     public function update(Request $request, $id)
     {
         $request->validate([
             'product_name'  => 'required|string|max:255',
             'brand'         => 'nullable|string|max:255',
             'description'   => 'required|string',
             'alert_stock'   => 'required|integer|min:0',
             'barcode'       => 'nullable|string|max:255',
             'qrcode'        => 'nullable|string|max:255',
             'product_image' => 'nullable|image|max:2048',
             'section_id'    => 'required|exists:sections,id',
             'category_id'   => 'required|exists:categories,id',
         ]);
     
         $product = ProductTwo::findOrFail($id);
     
         // Update image if new one is uploaded
         if ($request->hasFile('product_image')) {
             $this->deleteOldImage($product); // delete old image if exists
     
             $fileName = time() . '_' . $request->file('product_image')->getClientOriginalName();
             $request->file('product_image')->move(public_path('products/images'), $fileName);
             $product->product_image = $fileName;
         }
     
         // Update other fields
         $product->product_name   = $request->product_name;
         $product->brand          = $request->brand;
         $product->description    = $request->description;
         $product->alert_stock    = $request->alert_stock;
         $product->barcode        = $request->barcode;
         $product->qrcode         = $request->qrcode;
         $product->section_name   = Section::findOrFail($request->section_id)->section_name;
         $product->category_name  = Category::findOrFail($request->category_id)->category_name;
     
         $product->save();
     
         return redirect()->route('products_two.index')
                          ->with('success', 'Product updated successfully');
     }
     

    /* --------------------------------------------------------------------
     | DESTROY
     |-------------------------------------------------------------------*/
    public function destroy($id)
    {
        $product = ProductTwo::findOrFail($id);

        IncomingStock::where('product_code', $product->product_code)->delete();
        $this->deleteOldImage($product);
        $product->delete();

        return redirect()->route('products_two.index')
                         ->with('success', 'Product and associated stock deleted');
    }

    /* --------------------------------------------------------------------
     | ADD INCOMING STOCK  (keeps section/category names)
     |-------------------------------------------------------------------*/
    public function addIncomingStock(Request $request)
    {
        $request->validate([
            'product_code'  => 'required|string|exists:products_two,product_code',
            'quantity'      => 'required|integer|min:1',
            'cost_price'    => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'section_id'    => 'required|exists:sections,id',
            'category_id'   => 'required|exists:categories,id',
        ]);

        $product  = ProductTwo::where('product_code', $request->product_code)->firstOrFail();

        $totalStock = IncomingStock::where('product_code', $product->product_code)
                                   ->sum('quantity') + $request->quantity;

        IncomingStock::create([
            'product_code'  => $product->product_code,
            'product_name'  => $product->product_name,
            'quantity'      => $request->quantity,
            'cost_price'    => $request->cost_price,
            'selling_price' => $request->selling_price,
            'section_name'  => Section::findOrFail($request->section_id)->section_name,
            'category_name' => Category::findOrFail($request->category_id)->category_name,
            'total_stock'   => $totalStock,
            'batch_date'    => now(),
        ]);

        return back()->with('success', 'Incoming stock added successfully.');
    }
    

    /* --------------------------------------------------------------------
     | HELPER : Delete old image
     |-------------------------------------------------------------------*/
    private function deleteOldImage(ProductTwo $product): void
    {
        if ($product->product_image) {
            $path = public_path('products/images/' . $product->product_image);
            if (file_exists($path)) unlink($path);
        }
    }
   
}
