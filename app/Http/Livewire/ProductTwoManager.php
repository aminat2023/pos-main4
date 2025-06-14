<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductTwo;

class ProductTwoManager extends Component
{
    public $products;

    public function mount()
    {
        $this->products = ProductTwo::all();
    }

    public function render()
    {
        return view('livewire.product-two-manager', [
            'products' => $this->products,
        ]);
    }

    // Add any additional methods needed for managing products
}