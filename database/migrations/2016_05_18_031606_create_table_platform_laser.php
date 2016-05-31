<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlatformLaser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_laser', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_platform');
            $table->integer('id_laser');
            $table->integer('power');
            $table->double('cut_laser',30,20);
            $table->string('type');
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
