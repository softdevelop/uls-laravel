<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('user_group_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_group_id')->references('id')->on('groups')
                ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('department_id')->references('id')->on('departments')
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'user_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_user');
    }
}
