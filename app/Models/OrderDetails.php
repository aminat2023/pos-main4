<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory; // Use the HasFactory trait for factory support

    protected $table = 'order_details'; // Specify the table name

    protected $fillable = [
        'order_id',     // ID of the associated order
        'product_id',   // ID of the associated product
        'quantity',     // Quantity of the product in the order
        'unit_price',   // Price per unit of the product
        'amount',       // Total amount for this order detail
        'discount'      // Discount applied to this order detail
    ];

    // Relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Products::class); // Each order detail belongs to one product
    }

    // Relationship to the Order model
    public function order()
    {
        return $this->belongsTo(Order::class); // Each order detail belongs to one order
    }
}
