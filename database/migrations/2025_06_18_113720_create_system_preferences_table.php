<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemPreferencesTable extends Migration
{
    public function up()
    {
        Schema::create('system_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Optional: Seed default preferences
        DB::table('system_preferences')->insert([
            ['key' => 'business_name', 'value' => 'My Business'],
            ['key' => 'business_logo', 'value' => null],
            ['key' => 'currency_symbol', 'value' => '₦'],
            ['key' => 'tax_enabled', 'value' => '0'],
            ['key' => 'tax_percentage', 'value' => '0'],
            ['key' => 'default_language', 'value' => 'English'],
            ['key' => 'receipt_format', 'value' => 'Standard'],
            ['key' => 'datetime_format', 'value' => 'd/m/Y H:i'],
            ['key' => 'auto_logout_time', 'value' => '15'],
            ['key' => 'allow_discount', 'value' => '1'],
            ['key' => 'barcode_type', 'value' => 'Code128'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('system_preferences');
    }
}
