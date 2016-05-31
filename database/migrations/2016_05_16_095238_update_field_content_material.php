<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldContentMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_contents', function ($table) {
            if (Schema::hasColumn('material_contents', 'width')) {
                $table->dropColumn('width');
            }
            if (Schema::hasColumn('material_contents', 'height')) {
                $table->dropColumn('height');
            }
            if (Schema::hasColumn('material_contents', 'depth')) {
                $table->dropColumn('depth');
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
