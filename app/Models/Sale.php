<?php
namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = "sales";

    protected $fillable = [
        'product_name',
        'product_qty',
        'cost_price',
        'selling_price',
        'total_amount',
        'amount_paid',
        'balance',
        'method_of_payment',
        'profit',
        'user_id',
        'product_code',
    ];

    // Accessor for calculating profit
    public function getProfitAttribute()
    {
        return $this->selling_price - $this->cost_price;
    }
    public function product()
    {
        return $this->hasMany(\App\Models\Products::class);
    }

    // Relationship to Cart model (assuming App\Models\Cart)
    
    public function sales_details()
    {
        return $this->hasMany(\App\Models\SalesDetails::class);
    }
    public function incoming_product()
    {
        return $this->hasMany(\App\Models\IncomingProduct::class);
    }
}
