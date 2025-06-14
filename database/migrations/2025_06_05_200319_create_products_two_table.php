<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTwoTable extends Migration
{
    public function up()
    {
        Schema::create('products_two', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('section_name')->nullable(); // Add here
            $table->string('category_name')->nullable(); // Add here
            $table->text('description');
            $table->string('brand')->nullable();
            $table->integer('alert_stock')->default(10);
            $table->string('barcode')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_code')->unique();
            $table->date('batch_date')->nullable();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('products_two');
    }
}