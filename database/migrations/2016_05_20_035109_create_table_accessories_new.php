<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAccessoriesNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('accessories');
        // \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Schema::create('accessories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('dependencies', 50);
            $table->text('description');
            $table->text('benefits');
            $table->string('uuf',20);
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')
                                       ->on('categories')
                                       ->onUpdate('cascade')
                                       ->onDelete('cascade');
                                       
            // $table->foreign('category_id')->references('id')
            //                            ->on('categories')
            //                            ->onUpdate('set null')
            //                            ->onDelete('set null');
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
        Schema::drop('accessories');
    }
}
