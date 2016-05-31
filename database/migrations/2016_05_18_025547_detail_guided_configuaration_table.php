<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailGuidedConfiguarationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('infor_guide_config_user') &&  !Schema::hasTable('guided_configuarator')){
            Schema::create('guided_configuarator', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('base_id')->unsigned();
                $table->integer('infor_config_user_id')->unsigned();
                $table->double('min_thickness');
                $table->double('max_thickness');
                $table->double('min_global_laser');
                $table->double('max_global_laser');
                $table->double('power_at_max_thickness');
                $table->double('power_at_min_thickness');
                $table->double('width');
                $table->double('height');
                $table->double('depth');
                $table->boolean('dlsc');
                $table->boolean('mlcc');
                $table->boolean('question_first');
                $table->boolean('question_second');
                $table->boolean('question_third');
                $table->boolean('cut');
                $table->boolean('engraving');
                $table->boolean('otherSelect');
                $table->double('engrave_mark_recommended_power');
                $table->string('other');
                $table->string('unit');
                $table->string('platform_id')->nullable();

                $table->foreign('infor_config_user_id')->references('id')->on('infor_guide_config_user')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('base_id')->references('id')->on('materials')->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
            });
        } else {
            echo 'Can\'t create table guided_configuarator';

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
        Schema::drop('guided_configuarator');
    }
}
