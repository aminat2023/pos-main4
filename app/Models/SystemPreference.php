<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemPreference extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array', // Automatically cast value to array
    ];
}
