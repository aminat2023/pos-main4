<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id(); // Primary key
            // Change from sale_id to product_code
            $table->string('product_code'); // Assuming product_code is a string
            $table->string('product_name');
            $table->integer('product_qty');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('profit', 10, 2);
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_details');
    }
}
