<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    use HasFactory;

    // app/Models/SupplierPayment.php

    protected $fillable = [
        'supply_id',
        'supplier_id',
        'product_name',
        'quantity',
        'amount',
        'amount_paid',
        'balance',
        'payment_mode',
        'invoice_number'
    ];
    
    // Relationship to supply
    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
