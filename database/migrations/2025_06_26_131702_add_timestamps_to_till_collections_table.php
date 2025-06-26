<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToTillCollectionsTable extends Migration
{
    public function up()
    {
        Schema::table('till_collections', function (Blueprint $table) {
            $table->timestamps(); // adds `created_at` and `updated_at`
        });
    }

    public function down()
    {
        Schema::table('till_collections', function (Blueprint $table) {
            $table->dropTimestamps(); // drops `created_at` and `updated_at`
        });
    }
}
