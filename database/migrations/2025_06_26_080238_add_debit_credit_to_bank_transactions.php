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
        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->decimal('debit', 10, 2)->nullable()->after('amount');
            $table->decimal('credit', 10, 2)->nullable()->after('debit');
        });
    }
    
    public function down()
    {
        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->dropColumn(['debit', 'credit']);
        });
    }
    
};
