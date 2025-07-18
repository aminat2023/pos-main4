<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaultTransaction extends Model
{
    protected $fillable = [
      
        'amount',
        'debit',
        'credit',
        'reason',
        'user_id',
        'date'
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
