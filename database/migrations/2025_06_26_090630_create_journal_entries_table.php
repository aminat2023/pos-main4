<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable(); // e.g. SALE-001
            $table->string('account'); // e.g. Cash, Bank, Sales, Vault
            $table->decimal('debit', 12, 2)->nullable(); // Only one is filled per row
            $table->decimal('credit', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
