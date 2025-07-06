<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'full_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'residential_address',
        'phone',
        'email',
        'nin',
        'government_id',
        'utility_bill',
        'employment_status',
        'employer_name',
        'employer_address',
        'job_title',
        'monthly_income',
        'bank_statements',
        'credit_history',
        'existing_debts',
        'loan_amount',
        'loan_purpose',
        'repayment_plan',
        'collateral_docs',
        'guarantor_info',
    ];
    
}
