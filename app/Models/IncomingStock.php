<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class IncomingStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'quantity',
        'cost_price',
        'selling_price',
        'total_stock',
        'batch_date',
    ];
    public function product()
    {
        return $this->belongsTo(ProductTwo::class, 'product_code', 'product_code');
    }
    
}
