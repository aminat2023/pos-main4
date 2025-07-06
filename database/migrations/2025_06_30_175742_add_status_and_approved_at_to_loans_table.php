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
    Schema::table('loans', function (Blueprint $table) {
        $table->string('status')->default('Pending');
        $table->timestamp('approved_at')->nullable();
    });
}

public function down()
{
    Schema::table('loans', function (Blueprint $table) {
        $table->dropColumn(['status', 'approved_at']);
    });
}

};
