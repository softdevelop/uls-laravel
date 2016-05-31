<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RowboatTypePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        if (!Schema::hasTable('type_permission')) {
            
            Schema::create('type_permission', function(Blueprint $table)
            {
                $table->integer('type_id')->unsigned();

                $table->integer('permission_id')->unsigned();

                $table->tinyInteger('ticket_admin')->default(0);

                $table->foreign('type_id')->references('id')->on('types')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->foreign('permission_id')->references('id')->on('permissions')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->primary(['type_id', 'permission_id']);

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
        //
    }
}
