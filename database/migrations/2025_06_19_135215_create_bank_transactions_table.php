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
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // who performed the transaction
            $table->decimal('amount', 10, 2);
            $table->string('reference')->nullable();           // optional transaction reference
            $table->string('bank_name')->nullable();           // name of bank
            $table->string('payment_method')->default('bank'); // can be 'bank', 'transfer', etc.
            $table->date('date');
            $table->timestamps();
    
            // optional foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transactions');
    }
};
