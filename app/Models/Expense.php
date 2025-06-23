<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['description', 'amount', 'date', 'category'];

    // Ensure the amount is always stored as negative
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = -abs($value);
    }
}
