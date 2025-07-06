<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'note',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
