<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersFilesAssetManagerSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creates the folders_assetmanager table
      if (!Schema::hasTable('folders_assetmanager')) {
          Schema::create('folders_assetmanager', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
                
          });
      }


        // Creates the files_assetmanager table
      if(!Schema::hasTable('files_assetmanager')){

          Schema::create('files_assetmanager', function (Blueprint $table) {
              $table->increments('id');
              $table->string('file_name', 255);
              $table->string('stored_file_name', 255);
              $table->string('folder_file', 50);
              $table->string('title', 255);
              $table->string('description', 255);
              $table->string('size', 50);
              $table->string('type', 50);
              $table->string('store', 50);
              $table->integer('imageable_id')->unsigned();
              $table->string("imageable_type", 100);

              $table->integer('user_id')->unsigned();
              $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');

              $table->integer('folder_id')->unsigned();
              $table->foreign('folder_id')->references('id')->on('folders_assetmanager')
                    ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::drop('folders_assetmanager');
        Schema::drop('files_assetmanager');
    }
}
