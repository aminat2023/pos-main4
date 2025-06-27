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
        Schema::table('supplies', function (Blueprint $table) {
            $table->string('supplier_name')->nullable()->after('supplier_id');
        });
    }
    
    public function down()
    {
        Schema::table('supplies', function (Blueprint $table) {
            $table->dropColumn('supplier_name');
        });
    }
    
};
