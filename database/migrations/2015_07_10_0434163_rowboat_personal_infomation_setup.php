<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RowboatPersonalInfomationSetup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Creates the personal information user table
            Schema::create('personal_information', function (Blueprint $table) {
                  $table->increments('id');


                  $table->string('direct_phone')->nullable();
                  $table->string('fax')->nullable();
                  $table->string('address')->nullable();
                  $table->string('city')->nullable();
                  $table->string('state')->nullable();
                  $table->string('zip')->nullable();
                  $table->string('latitude')->nullable();
                  $table->string('longitude')->nullable();

                  $table->string('branch_address')->nullable();
                  $table->string('work_email')->nullable();
                  $table->string('personal_email')->nullable();

                  $table->string('home_address')->nullable();
                  $table->string('home_city')->nullable();
                  $table->string('home_state')->nullable();
                  $table->string('home_zip', 63)->nullable();

                  $table->string('home_latitude')->nullable();
                  $table->string('home_longitude')->nullable();
                  $table->string('work_mobile')->nullable();
                  $table->string('work_phone')->nullable();
                  $table->string('work_address')->nullable();
                  $table->string('work_city')->nullable();
                  $table->string('work_state')->nullable();
                  $table->string('work_zip', 63)->nullable();

                  $table->string('work_latitude')->nullable();
                  $table->string('work_longitude')->nullable();


                  $table->integer('user_id')->unsigned();

                  $table->foreign('user_id')->references('id')->on('users')
                      ->onUpdate('cascade')->onDelete('cascade');

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
		Schema::drop('personal_information');
	}

}
