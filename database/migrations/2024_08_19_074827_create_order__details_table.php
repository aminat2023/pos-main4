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
    if (!Schema::hasTable('order_details')) {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('selling_price', 10, 2);
            $table->integer('amount');
            $table->integer('discount');
            $table->timestamps();
        });
    }
}

public function down()
{
    Schema::dropIfExists('order_details');
}
};
