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
        Schema::create('vault_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in', 'out']); // in = deposit to vault, out = withdrawal
            $table->decimal('amount', 10, 2);
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // who performed it
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vault_transactions');
    }
};
