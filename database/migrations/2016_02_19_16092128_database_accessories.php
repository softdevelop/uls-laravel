<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseAccessories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('accessories')) {
            Schema::create('accessories', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                // $table->integer('accessory_id')->nullable();
                $table->integer('active')->nullable();
                $table->string('accessory_title', 75)->nullable();
                $table->string('link', 100)->nullable();
                $table->string('link_type', 15)->nullable();
                $table->string('image_1', 25)->nullable();
                $table->string('image_2', 25)->nullable();
                $table->string('image_3', 25)->nullable();
                $table->string('image_4', 25)->nullable();
                $table->string('image_5', 25)->nullable();
                $table->text('accessory_text')->nullable();
                $table->tinyInteger('popularity')->nullable();
                $table->tinyInteger('cutting')->nullable();
                $table->tinyInteger('engraving')->nullable();
                $table->tinyInteger('improve_quality')->nullable();
                $table->tinyInteger('uniquely')->nullable();
                $table->tinyInteger('integration')->nullable();
                $table->tinyInteger('objects')->nullable();
                $table->tinyInteger('improve_speed')->nullable();
                // $table->integer('page_id')->nullable();
                // $table->integer('section_id')->nullable();
                // $table->integer('active_dev')->nullable();
                $table->timestamps();
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
        Schema::drop('accessories');
    }
}
