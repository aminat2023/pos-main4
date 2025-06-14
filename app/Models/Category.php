<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importing HasMany relationship

class Category extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = ['category_name', 'section_id', 'discount', 'description', 'status'];

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id'); 
    }

    public function subCategories(): HasMany // Method name corrected to camelCase
    {
        return $this->hasMany(SubCategory::class); // Use actual foreign and local keys
    }
}
