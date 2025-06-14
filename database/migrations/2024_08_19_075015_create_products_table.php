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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('description');
            $table->string('brand')->nullable();
            $table->integer('cost_price')->nullable(); // Changed to nullable
            $table->integer('selling_price')->nullable(); // Changed to nullable
            $table->integer('quantity');
            $table->string('product_code')->unique(); 
            $table->integer('alert_stock')->default('10');
            $table->text('barcode')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('product_image')->nullable();
            $table->timestamps();
            $table->date('batch_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
