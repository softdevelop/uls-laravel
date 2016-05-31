<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RowboatTicketSetupTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Creates the users table
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 100);
            $table->string('type_of_program', 100);
            $table->string('website_of_source');
            $table->string('title');
            $table->string('form_associated');
            $table->string('loan',20);
            $table->string('status')->default('open');
            $table->string('priority', 20);
            $table->integer('user_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('assign_id')->nullable()->unsigned();
            $table->string('decision',100);
            $table->dateTime('date_closed');
            $table->dateTime('date_current_open');
            $table->string('time_consuming');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes(); 


        });



         $statement = "
                        ALTER TABLE tickets AUTO_INCREMENT = 1000;
                    ";

        DB::unprepared($statement);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		 Schema::drop('tickets');
	}

}
