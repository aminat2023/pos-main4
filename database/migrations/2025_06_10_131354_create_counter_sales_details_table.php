<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterSalesDetailsTable extends Migration
{
    public function up()
{
    Schema::create('counter_sales_details', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('product_name')->default('Unknown Product'); // Default name for the product
        $table->string('product_code')->default('DEFAULT_CODE'); // Default code for the product
        $table->integer('quantity')->default(0); // Default quantity sold
        $table->decimal('cost_price', 10, 2)->default(0.00); // Default cost price of the product
        $table->decimal('selling_price', 10, 2)->default(0.00); // Default selling price of the product
        $table->decimal('total_amount', 10, 2)->default(0.00); // Default total amount for the sale
        $table->decimal('amount_paid', 10, 2)->default(0.00); // Default amount paid by the customer
        $table->decimal('balance', 10, 2)->default(0.00); // Default balance amount
        $table->string('method_of_payment')->default('Cash'); // Default payment method used
        $table->decimal('profit', 10, 2)->default(0.00); // Default profit made from the sale
        $table->unsignedBigInteger('user_id'); // Foreign key to link to the user who made the sale
        $table->decimal('discount', 10, 2)->nullable()->default(0.00); // Default discount applied, nullable if not applicable
        $table->timestamps(); // Created at and updated at timestamps
    });
}


    public function down()
    {
        Schema::dropIfExists('counter_sales_details');
    }
}
