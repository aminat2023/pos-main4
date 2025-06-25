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
        'amount_paid',
        'balance',
        'payment_mode',
    ];

    // Relationship to supply
    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
