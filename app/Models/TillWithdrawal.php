<?php
// app/Models/TillWithdrawal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TillWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'cashier_id',
        'destination',
        'denominations',
        'total_amount',
        'available_balance',
        'notes',
    ];
    
    protected $casts = [
        'denominations' => 'array',
    ];

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function cashier() {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
