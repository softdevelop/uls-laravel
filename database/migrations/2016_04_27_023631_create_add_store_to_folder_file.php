<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddStoreToFolderFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('folders', function ($table) 
        {
            if (!Schema::hasColumn('folders', 'store')) {
                $table->string('store')->nullable();
            }

            if (!Schema::hasColumn('folders', 'visible')) {
                $table->boolean('visible')->default(1);
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
