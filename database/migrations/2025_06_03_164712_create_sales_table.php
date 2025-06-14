<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('product_qty');
            $table->decimal('cost_price', 8, 2); // Cost price
            $table->decimal('selling_price', 8, 2); // Selling price
            $table->decimal('profit', 8, 2)->nullable(); // Profit
            $table->decimal('total_amount', 10, 2)->default(0.00); // Total amount
            $table->decimal('amount_paid', 10, 2)->default(0.00); // Amount paid
            $table->decimal('balance', 10, 2)->default(0.00); // Balance
            $table->string('method_of_payment', 50); // Method of payment
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User reference
            $table->string('product_code'); // Product code
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
