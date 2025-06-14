<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_counter_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterCartsTable extends Migration
{
    public function up()
    {
        Schema::create('counter_carts', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code');
            $table->integer('quantity');
            $table->decimal('selling_price', 10, 2);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('counter_carts');
    }
}
