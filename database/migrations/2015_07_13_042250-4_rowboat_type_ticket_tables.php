<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RowboatTypeTicketTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->tinyInteger('position_show')->default('0');
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::table('permissions', function (Blueprint $table) {
        	$table->integer('type_id')->nullable()->unsigned();
        	$table->foreign('type_id')->references('id')->on('types')
                ->onUpdate('cascade')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		 Schema::drop('types');
	}

}
