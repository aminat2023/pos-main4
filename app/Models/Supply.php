<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    // use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_name',
        'quantity',
        'unit_price',
    ];

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
