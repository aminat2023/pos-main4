

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
        if (!Schema::hasTable('sections')) {
            Schema::create('sections', function (Blueprint $table) {
                $table->id();
                $table->string('section_name')->default('Unnamed Section');
                $table->tinyInteger('status')->default(0)->comment('0 = Disabled, 1 = Enabled');
                $table->timestamps(); // This will add 'created_at' and 'updated_at' columns
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
};