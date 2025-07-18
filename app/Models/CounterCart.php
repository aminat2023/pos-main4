<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_code',
        'quantity',
        'selling_price',
        'user_id',
    ];

    /**
     * Relationship to User (the cashier who added to cart)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Product (assuming IncomingStock or ProductTwo holds product info)
     * Replace IncomingStock with ProductTwo if that’s your main product model
     */
    public function product()
    {
        return $this->belongsTo(IncomingStock::class, 'product_code', 'product_code');
        // Or if you're using ProductTwo model:
        // return $this->belongsTo(ProductTwo::class, 'product_code', 'product_code');
    }

    
    public function details()
{
    return $this->hasMany(CounterSalesDetail::class, 'counter_sales_id');
}
}
