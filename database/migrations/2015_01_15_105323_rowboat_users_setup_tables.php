<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RowboatUsersSetupTables extends Migration {

	/**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        if (!Schema::hasTable('users')){
            //Creates the users table
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email')->unique();
               
                $table->string('password');
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->string('avatar');
                $table->string('confirmation_code');
                $table->string('remember_token')->nullable();
                $table->string('authtype', 63);

                $table->boolean('confirmed')->default(false);

                $table->tinyInteger('is_online')->nullable()->default(0);

                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('password_reminders')){
            //Creates password reminders table
            Schema::create('password_reminders', function (Blueprint $table) {
                $table->string('email');
                $table->string('token');
                $table->timestamp('created_at'); 
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('password_reminders');
        Schema::drop('users');
    }

}
