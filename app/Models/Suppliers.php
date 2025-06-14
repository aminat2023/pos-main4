<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';
    protected $fillable = [
     'supplier_name',
     'supplier_address'
    ,'phone_number' 
    ,'e_mail' 
   
];
}
