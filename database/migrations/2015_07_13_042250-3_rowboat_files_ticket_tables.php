<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RowboatFilesTicketTables extends Migration {

	/**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('files_ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
             $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('file_name', 255);
            $table->string('stored_file_name', 255);
            $table->string('folder_file', 50);
            $table->string('title', 255);
            $table->string('description', 255);
            // $table->integer('role_id')->unsigned();
            $table->string('size', 50);
            $table->string('type', 50);
            $table->string('store', 50);
            $table->integer('imageable_id')->unsigned();
            $table->string("imageable_type", 100);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('files_ticket');
        
    }

}
