<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'description',
        'brand',
        'cost_price',
        'selling_price',
        'quantity',
        'alert_stock',
        'barcode',
        'qrcode',
        'product_image'
    ];

    // Relationship to Order model (assuming App\Models\Order)
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    // Relationship to Cart model (assuming App\Models\Cart)
    
    public function carts()
    {
        return $this->hasMany(\App\Models\Cart::class);
    }
 
    public function isLowStock()
    {
        return $this->alert_stock< 10; // Change this threshold as needed
    }

   
  
}
