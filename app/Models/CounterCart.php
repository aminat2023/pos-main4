<?php
// app/Models/CounterCart.php

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
}
