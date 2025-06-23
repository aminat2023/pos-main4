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
    Schema::table('till_withdrawals', function (Blueprint $table) {
        $table->decimal('available_balance', 10, 2)->nullable()->after('total_amount');
    });
}

public function down()
{
    Schema::table('till_withdrawals', function (Blueprint $table) {
        $table->dropColumn('available_balance');
    });
}

};
