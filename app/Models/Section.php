<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    // Correctly define the fillable attributes
    protected $fillable = [
        'section_name', // Name of the section
        'status'        // Status of the section (active/inactive)
    ];

     public function category(): HasMany// Corrected return type syntax
    {
        return $this->hasMany(Category::class);
    }

}



