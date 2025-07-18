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
        Schema::table('counter_sales_details', function (Blueprint $table) {
            $table->string('invoice_no')->nullable()->after('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('counter_sales_details', function (Blueprint $table) {
            $table->dropColumn('invoice_no');
        });
    }
    
};
