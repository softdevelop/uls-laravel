<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableTranslationQueueSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('translation_queue', function($table)
        {
            $table->dropUnique('translation_queue_name_unique');
            $table->dropColumn('alias_name');
            $table->dropColumn('active');
            $table->string('name')->nullable()->change();
            $table->string('meta')->nullable();
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->longText('description')->nullable();
            $table->integer('status')->nullable();
            $table->integer('priority')->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('translation_queue', function ($table) {
        //     $table->dropForeign(['page_id','language_id']);
        //     // $table->dropColumn(['name', 'meta', 'title','heading', 'subheading', 'description', 'status']);
        // });
        // Schema::drop('translation_queue');
    }
}
