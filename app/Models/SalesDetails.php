<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'product_qty',
        'selling_price',
        'profit',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

   


}

