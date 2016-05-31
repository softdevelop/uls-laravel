<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InforGuideConfigUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('infor_guide_config_user')) {
            Schema::create('infor_guide_config_user', function(Blueprint $table) {
                $table->increments('id');
                $table->string('url');
                $table->integer('user_id')->unsigned();
                $table->string('email');

                $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
            });
        } else {
            echo 'Can\'t create table infor_guide_config_user';

            return;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('infor_guide_config_user');
    }
}
