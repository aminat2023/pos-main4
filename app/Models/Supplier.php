<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id', // Custom ID
        'name', 
        'phone', 
        'email', 
        'address'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            // Generate a custom ID that starts with 'SUP'
            $latestSupplier = DB::table('suppliers')->orderBy('id', 'desc')->first();
            $nextId = 1; // Default to 1 if no suppliers exist

            if ($latestSupplier) {
                // Extract the numeric part and increment it
                $lastId = (int) substr($latestSupplier->supplier_id, 3);
                $nextId = $lastId + 1;
            }

            $supplier->supplier_id = 'SUP' . str_pad($nextId, 5, '0', STR_PAD_LEFT); // Format: SUP00001
        });
    }
}
