<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaterialContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_contents', function (Blueprint $table) {
            $table->increments('id');
            
            $table->boolean('engrave_mark');
            $table->integer('engrave_mark_recommended_power');
            $table->double('min_thickness',15,3);
            $table->integer('power_at_min_thickness');
            $table->double('max_thickness',15,3);
            $table->integer('power_at_max_thickness');
            $table->double('wave_length',15,3);
            $table->boolean('cut');
            $table->double('width',15,3);
            $table->double('height',15,3);
            $table->double('depth',15,3);
            $table->integer('base_id')->unsigned();
            $table->string('language');
            $table->string('region');

            $table->foreign('base_id')->references('id')->on('materials')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('material_contents');
    }
}
