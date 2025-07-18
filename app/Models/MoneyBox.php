<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyBox extends Model
{
    protected $fillable = ['bank_name', 'balance'];

    protected $casts = [
        'balance' => 'float',
    ];
}
