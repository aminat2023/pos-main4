<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Make the supply_id column nullable
        DB::statement("ALTER TABLE supplier_payments MODIFY supply_id BIGINT UNSIGNED NULL");
    }

    public function down()
    {
        // Revert to NOT NULL if needed
        DB::statement("ALTER TABLE supplier_payments MODIFY supply_id BIGINT UNSIGNED NOT NULL");
    }
};
