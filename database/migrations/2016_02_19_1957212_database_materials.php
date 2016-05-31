<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('materials')) {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            // $table->integer('link_id')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('page_title', 200)->nullable();
            // $table->integer('page_id')->nullable();
            $table->string('image', 25)->nullable();
            $table->text('keywords')->nullable();
            $table->string('description', 400)->nullable();
            $table->string('subtitle', 200)->nullable();
            $table->text('overview')->nullable();
            $table->string('subtitle1', 150)->nullable();
            $table->string('subtitle2', 150)->nullable();
            $table->string('subtitle3', 150)->nullable();
            $table->string('subtitle4', 150)->nullable();
            $table->string('subtitle5', 150)->nullable();
            $table->string('subtitle6', 150)->nullable();
            $table->text('text1')->nullable();
            $table->text('text2')->nullable();
            $table->text('text3')->nullable();
            $table->text('text4')->nullable();
            $table->text('text5')->nullable();
            $table->text('text6')->nullable();
            $table->string('caption1', 200)->nullable();
            $table->string('caption2', 200)->nullable();
            $table->string('caption3', 200)->nullable();
            $table->string('caption4', 200)->nullable();
            $table->string('caption5', 200)->nullable();
            $table->string('caption6', 200)->nullable();
            $table->string('alt1', 200)->nullable();
            $table->string('alt2', 200)->nullable();
            $table->string('alt3', 200)->nullable();
            $table->string('alt4', 200)->nullable();
            $table->string('alt5', 200)->nullable();
            $table->string('alt6', 200)->nullable();
            $table->string('alt7', 200)->nullable();
            $table->string('alt8', 200)->nullable();
            $table->string('alt9', 200)->nullable();
            $table->string('alt10', 200)->nullable();
            $table->string('alt11', 200)->nullable();
            $table->string('alt12', 200)->nullable();
            $table->string('alt13', 200)->nullable();
            $table->string('alt14', 200)->nullable();
            $table->string('alt15', 200)->nullable();
            $table->string('alt16', 200)->nullable();
            $table->string('image1', 25)->nullable();
            $table->string('image2', 25)->nullable();
            $table->string('image3', 25)->nullable();
            $table->string('image4', 25)->nullable();
            $table->string('image5', 25)->nullable();
            $table->string('image6', 25)->nullable();
            $table->string('image7', 25)->nullable();
            $table->string('image8', 25)->nullable();
            $table->string('image9', 25)->nullable();
            $table->string('image10', 25)->nullable();
            $table->string('style1', 300)->nullable();
            $table->string('style2', 300)->nullable();
            $table->string('style3', 300)->nullable();
            $table->string('style4', 300)->nullable();
            $table->string('style5', 300)->nullable();
            $table->string('style6', 300)->nullable();
            $table->string('style7', 300)->nullable();
            $table->string('style8', 300)->nullable();
            $table->string('style9', 300)->nullable();
            $table->string('style10', 300)->nullable();
            $table->string('style11', 300)->nullable();
            $table->string('style12', 300)->nullable();
            $table->string('style13', 300)->nullable();
            $table->string('style14', 300)->nullable();
            $table->string('style15', 300)->nullable();
            $table->string('style16', 300)->nullable();
            $table->string('class1', 3)->nullable();
            $table->string('class2', 3)->nullable();
            $table->string('class3', 3)->nullable();
            $table->string('class4', 3)->nullable();
            $table->string('class5', 3)->nullable();
            $table->string('class6', 3)->nullable();
            $table->string('class7', 3)->nullable();
            $table->string('class8', 3)->nullable();
            $table->string('class9', 3)->nullable();
            $table->string('class10', 3)->nullable();
            $table->string('class11', 3)->nullable();
            $table->string('class12', 3)->nullable();
            $table->string('class13', 3)->nullable();
            $table->string('class14', 3)->nullable();
            $table->string('class15', 3)->nullable();
            $table->string('class16', 3)->nullable();
            // $table->integer('section_id')->nullable();
            $table->string('language', 2)->nullable();
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
        Schema::drop('materials');
    }
}
