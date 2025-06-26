<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vault_transactions', function (Blueprint $table) {
            $table->decimal('debit', 15, 2)->nullable()->after('amount');
            $table->decimal('credit', 15, 2)->nullable()->after('debit');
        });
    }

    public function down(): void
    {
        Schema::table('vault_transactions', function (Blueprint $table) {
            $table->dropColumn(['debit', 'credit']);
        });
    }
};
