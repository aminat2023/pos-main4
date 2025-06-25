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
        'amount',
        'amount_paid',
        'balance',
        'payment_status',
        'supply_id', 
    ];
    

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    

    public function payment()
{
    return $this->hasOne(SupplierPayment::class);
}


}
