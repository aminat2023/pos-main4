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
    Schema::table('supplier_payments', function (Blueprint $table) {
        $table->unsignedBigInteger('supply_id')->after('id');

        // Optional: add a foreign key constraint
        $table->foreign('supply_id')->references('id')->on('supplies')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('supplier_payments', function (Blueprint $table) {
        $table->dropForeign(['supply_id']);
        $table->dropColumn('supply_id');
    });
}

};
