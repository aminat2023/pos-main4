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
        Schema::create('till_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // admin who collects
            $table->unsignedBigInteger('cashier_id'); // cashier who handled the till
            $table->decimal('total_amount', 10, 2);
            $table->decimal('available_balance', 10, 2)->nullable(); // ✅ add this line
            $table->string('destination'); // 'bank' or 'vault'
            $table->json('denominations'); // denominations breakdown
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('till_withdrawals');
    }
};
