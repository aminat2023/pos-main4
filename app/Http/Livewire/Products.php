<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Products as ProductsModel;

class Products extends Component
{
    public $products_details = [];
    public $categories = [];
    public $subcategories = [];
    public $selected_category;
    public $products; // Declare as a variable, no need to initialize here

    public function mount()
    {
        $this->categories = Category::all();
        $this->products = ProductsModel::all(); // This will be a Collection
    }


    public function updatedSelectedCategory($categoryId)
    {
        $this->subcategories = SubCategory::where('category_id', $categoryId)->get();
    }

    public function ProductDetails($product_id)
    {
        $this->products_details = ProductsModel::where('id', $product_id)->get();
    }

    function getStockMessage($product) {
        if ($product->quantity < 10) {
            return "Product {$product->product_name} is low in stock: {$product->quantity}";
        } else {
            return "{$product->product_name} - Stock: {$product->quantity}";
        }
    }
    

    public function render()
    {
        return view('livewire.products', [
            'products' => $this->products,
            'categories' => $this->categories,
            'subcategories' => $this->subcategories
        ]);
    }
}
