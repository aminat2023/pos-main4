<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCodesTable extends Migration
{
    public function up()
    {
        Schema::create('product_codes', function (Blueprint $table) {
            $table->string('code')->primary(); // Primary key
            $table->string('description')->nullable(); // Description of the product
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_codes');
    }
}
