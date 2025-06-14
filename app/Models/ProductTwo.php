<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTwo extends Model
{
    use HasFactory;

    protected $table = 'products_two';

    protected $fillable = [
        'product_name',
        'section_name',       // ✅ add this
        'category_name',      // ✅ add this
        'description',
        'brand',
        'alert_stock',
        'barcode',
        'qrcode',
        'product_image',
        'product_code',       // Optional but useful if you're setting it manually
        'batch_date',         // Optional if you're setting it manually
    ];
}