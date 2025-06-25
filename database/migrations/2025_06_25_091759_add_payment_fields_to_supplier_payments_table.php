<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('supplier_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('supplier_payments', 'amount_paid')) {
                $table->decimal('amount_paid', 12, 2)->default(0)->after('amount');
            }

            if (!Schema::hasColumn('supplier_payments', 'balance')) {
                $table->decimal('balance', 12, 2)->default(0)->after('amount_paid');
            }
        });
    }

    public function down()
    {
        Schema::table('supplier_payments', function (Blueprint $table) {
            $table->dropColumn('amount_paid');
            $table->dropColumn('balance');
        });
    }
};
