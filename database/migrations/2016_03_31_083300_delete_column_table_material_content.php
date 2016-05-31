<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnTableMaterialContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_contents', function ($table) {
            $table->dropColumn(['min_thickness', 'max_thickness', 'wave_length', 'width', 'height', 'depth']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_contents', function ($table) {
            $table->double('min_thickness',30,20);
            $table->double('max_thickness',30,20);
            $table->double('wave_length',30,20);
            $table->double('width',30,20);
            $table->double('height',30,20);
            $table->double('depth',30,20);
        });
    }
}
