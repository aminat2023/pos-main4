<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterSalesDetail extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'counter_sales_details';

    // Define the fillable attributes
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_code',
        'product_name',
        'quantity',
        'cost_price',
        'selling_price',
        'total_amount',
        'amount_paid',
        'balance',
        'method_of_payment',
        'profit',
        'discount',
    ];

    // Define any relationships if needed
    // For example, if you have a User model and want to link it
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // // You can also define a relationship with a product model if applicable
    // public function product()
    // {
    //     return $this->belongsTo(ProductTwo::class, 'product_code', 'code'); // Adjust 'code' to the actual field in your products table
    // }
}
