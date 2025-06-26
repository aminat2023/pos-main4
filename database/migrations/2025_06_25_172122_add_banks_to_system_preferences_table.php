<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBanksToSystemPreferencesTable extends Migration
{
    public function up()
    {
        Schema::table('system_preferences', function (Blueprint $table) {
            $table->json('banks')->nullable(); // Use json type for array of banks
        });
    }

    public function down()
    {
        Schema::table('system_preferences', function (Blueprint $table) {
            $table->dropColumn('banks'); // Drop the column if rolled back
        });
    }
}
