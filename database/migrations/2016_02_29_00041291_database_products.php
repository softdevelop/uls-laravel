<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 100)->nullable();
            $table->string('subtitle', 300)->nullable();
            $table->string('page_title', 50)->nullable();
            $table->string('laser_platform', 50)->nullable();
            $table->string('power_configuration', 100)->nullable();
            $table->string('laser_interface', 50)->nullable();
            $table->string('rapid_reconfiguration', 50)->nullable();
            $table->string('superspeed', 20)->nullable();
            $table->string('pass_through', 30)->nullable();
            $table->string('multiwave', 30)->nullable();
            $table->string('work_area', 25)->nullable();
            $table->string('single_laser_config', 50)->nullable();
            $table->string('dual_laser_config', 50)->nullable();
            $table->string('view_details', 30)->nullable();
            $table->string('overview', 30)->nullable();
            $table->text('details_ils1275')->nullable();
            $table->text('details_ils975')->nullable();
            $table->text('details_pls6mw')->nullable();
            $table->text('details_pls6150d_ss')->nullable();
            $table->text('details_pls6150d')->nullable();
            $table->text('details_pls675')->nullable();
            $table->text('details_pls475')->nullable();
            $table->text('details_vls660')->nullable();
            $table->text('details_vls460')->nullable();
            $table->text('details_vls360')->nullable();
            $table->text('details_vls350')->nullable();
            $table->text('details_vls230')->nullable();
            $table->string('download', 50)->nullable();
            $table->string('configure_system', 50)->nullable();
            $table->string('measurements', 50)->nullable();
            $table->string('with_superspeed', 50)->nullable();
            $table->string('multiwavelength', 50)->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            // $table->integer('page_id')->nullable();
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
        Schema::drop('products');
    }
}
