<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAndRemoveColumbContentMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_contents', function ($table) {
            if (Schema::hasColumn('material_contents', 'engrave_mark')) {
                $table->dropColumn('engrave_mark');
            }
            if (Schema::hasColumn('material_contents', 'wave_length')) {
                $table->dropColumn('wave_length');
            }
            if (Schema::hasColumn('material_contents', 'language')) {
                $table->dropColumn('language');
            }
            if (Schema::hasColumn('material_contents', 'region')) {
                $table->dropColumn('region');
            }
            if (!Schema::hasColumn('material_contents', 'laser_type')) {
                $table->string('laser_type');
            }
            if (!Schema::hasColumn('material_contents', 'fixed_thickness')) {
                $table->boolean('fixed_thickness')->default(false);
            }
            if (!Schema::hasColumn('material_contents', 'can_be_rastered')) {
                $table->boolean('can_be_rastered')->default(false);
            }
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
