<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the files_assetmanager table
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('url', 255);
            $table->dateTime('dateLiveBy');
            $table->dateTime('dateAvailable');
            $table->dateTime('toDate');
            $table->string('meta', 255);
            $table->string('title', 255);
            $table->string('heading', 255);
            $table->string('subHeading', 255);
            $table->string('description', 255);
            $table->integer('parent_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::drop('pages');
    }
}
