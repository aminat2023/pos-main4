<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingProductsTable extends Migration
{
    public function up()
{
    // Check if the table already exists
    if (!Schema::hasTable('incoming_products')) {
        Schema::create('incoming_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->default('unknown');
            $table->string('product_name')->nullable(); // Allow null values for product_name
            $table->integer('quantity')->default(0);
            $table->decimal('cost_price', 10, 2)->default(0.00);
            $table->decimal('selling_price', 10, 2)->default(0.00);
            $table->date('batch_date')->nullable()->default(null);
            $table->timestamps();
        });
    }
}

    public function down()
    {
        Schema::dropIfExists('incoming_products');
    }
}
