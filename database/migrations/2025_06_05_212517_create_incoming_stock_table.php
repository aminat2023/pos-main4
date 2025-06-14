<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingStockTable extends Migration
{
    public function up()
    {
        Schema::create('incoming_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_code'); // Foreign key from products_two
            $table->string('product_name'); // New column for product name
            $table->integer('quantity');
            $table->decimal('cost_price', 8, 2);
            $table->decimal('selling_price', 8, 2);
            $table->integer('total_stock')->default(0);
            $table->date('batch_date')->default(now());
            $table->timestamps();
        });
    }

    public function down()  
    {
        Schema::dropIfExists('incoming_stocks');
    }
}
