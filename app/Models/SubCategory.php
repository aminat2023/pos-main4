<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import the relationship class
use Illuminate\Database\Eloquent\Relations\HasMany; // Import the relationship class

class SubCategory extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = ['sub_category_name', 'category_id', 'status'];

    // Relationships
    public function category(): BelongsTo // Corrected return type syntax
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

   
}
