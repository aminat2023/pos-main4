<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            
            // Personal Info
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('marital_status');
            $table->text('residential_address');
            $table->string('phone');
            $table->string('email')->nullable();
        
            // ID Docs
            $table->string('nin')->nullable();
            $table->string('government_id')->nullable();
            $table->string('utility_bill')->nullable();
        
            // Employment Info
            $table->string('employment_status');
            $table->string('employer_name')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('job_title')->nullable();
            $table->decimal('monthly_income', 12, 2)->nullable();
        
            // Financial Info
            $table->text('bank_statements')->nullable(); // Can store file path or note
            $table->text('credit_history')->nullable();
            $table->text('existing_debts')->nullable();
        
            // Loan Info
            $table->decimal('loan_amount', 12, 2);
            $table->string('loan_purpose');
            $table->string('repayment_plan');
        
            // Additional Docs
            $table->text('collateral_docs')->nullable();
            $table->text('guarantor_info')->nullable();
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
