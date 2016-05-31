<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldStateAccessoriesPlatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessories_platform', function (Blueprint $table) {
            $table->integer('accessory_id')->unsigned();
            $table->integer('platform_id')->unsigned();
            $table->string('state', 20)->default('N/A');
            $table->foreign('accessory_id')->references('id')
                                       ->on('accessories')
                                       ->onUpdate('cascade')
                                       ->onDelete('cascade');
            $table->foreign('platform_id')->references('id')
                                       ->on('platform')
                                       ->onUpdate('cascade')
                                       ->onDelete('cascade');
      
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
