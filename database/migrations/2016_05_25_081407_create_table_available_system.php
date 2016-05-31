<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAvailableSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_system', function (Blueprint $table) {
            $table->increments('id');
            $table->double('single_laser_system')->nullable();
            $table->double('dual_laser_system')->nullable();
            $table->double('fiber_lasers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('available_system');
    }
}
