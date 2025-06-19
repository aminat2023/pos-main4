<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TillCollection extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'date',
    ];
}
