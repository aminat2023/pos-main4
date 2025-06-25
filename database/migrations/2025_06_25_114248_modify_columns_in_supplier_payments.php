<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE supplier_payments MODIFY invoice_number VARCHAR(255) NULL");
        DB::statement("ALTER TABLE supplier_payments MODIFY amount DECIMAL(12,2) DEFAULT 0");
        DB::statement("ALTER TABLE supplier_payments MODIFY quantity INT DEFAULT 0");
    }

    public function down()
    {
        DB::statement("ALTER TABLE supplier_payments MODIFY invoice_number VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE supplier_payments MODIFY amount DECIMAL(12,2) NOT NULL");
        DB::statement("ALTER TABLE supplier_payments MODIFY quantity INT NOT NULL");
    }
};
