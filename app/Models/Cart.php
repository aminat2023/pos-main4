<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "carts";
    
    // Fix typo: 'prroduct_price' -> 'product_price'
    protected $fillable = ['product_id', 'product_qty', 'product_price', 'user_id'];

    // Correct namespace reference to App\Models\Products
    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'product_id');
    }
}

