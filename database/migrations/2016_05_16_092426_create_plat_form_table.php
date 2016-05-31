<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->boolean('fiber')->default(false);
            $table->integer('width');
            $table->integer('height');
            $table->integer('depth');
            $table->boolean('width_exceptions')->default(false);
            $table->integer('max_co2_lsrpwr');
            $table->boolean('productivity')->default(false);
            $table->boolean('dual_laser')->default(false);
            $table->boolean('multiple_laser')->default(false);
            $table->timestamps();

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
