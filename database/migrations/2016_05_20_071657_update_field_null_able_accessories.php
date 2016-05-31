<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldNullAbleAccessories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessories', function ($table) {
            $table->string('dependencies', 50)->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('benefits')->nullable()->change();
            $table->string('uuf',20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
