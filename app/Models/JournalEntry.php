<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'reference',
        'account',
        'bank_name',
        'debit',
        'credit',
        'description',
        'date',
        'user_id',
    ];
}

