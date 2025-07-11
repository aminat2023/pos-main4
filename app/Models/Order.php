<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'name',
        'phone',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    // Define the relationship with Transactions
    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
