<?php

// app/Models/SystemPreference.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemPreference extends Model
{
    protected $fillable = ['key', 'value'];
}
