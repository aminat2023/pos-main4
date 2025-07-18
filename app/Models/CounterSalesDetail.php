<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterSalesDetail extends Model
{
    use HasFactory;

    protected $table = 'counter_sales_details';

    protected $fillable = [
        'user_id',
        'invoice_no', // 👈 add this
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

    // Relationship to User as cashier
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Use this in Blade: $sale->user->name
    }

    // Optional: If your table uses 'cashier_id' instead of 'user_id'
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id'); // Use this in Blade: $sale->cashier->name
    }

    // Relationship to product
    public function product()
    {
        return $this->belongsTo(IncomingStock::class, 'product_code', 'product_code'); // adjust field if needed
    }


}
