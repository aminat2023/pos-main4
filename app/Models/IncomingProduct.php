<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingProduct extends Model
{
    use HasFactory;

    // Specify the fillable fields if needed
    protected $fillable = [
        'product_code',
        'product_name',
        'quantity',
        'cost_price',  // Add cost_price to fillable
        'selling_price', // Add selling_price to fillable
        'batch_date'    // Add batch_date to fillable
    ];
    
    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class);
    }
    public function products()
    {
        return $this->hasMany(\App\Models\Products::class);
    }

    // Relationship to Cart model (assuming App\Models\Cart)
    
    public function sales_details()
    {
        return $this->hasMany(\App\Models\SalesDetails::class);
    }
    
}
