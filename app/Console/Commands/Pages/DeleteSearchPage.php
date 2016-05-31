<?php

namespace App\Console\Commands\Pages;

use Illuminate\Console\Command;

class DeleteSearchPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @author Minh than <than@httsolution.com>
     *
     * command php artisan cms:delete_search_page
     * @var string
     */
    protected $signature = 'cms:delete_search_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete search page';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start delete search page...');

        $indexs = [];
        $indexs[] = env('es_index', 'pages_dev');
        $indexs[] = env('es_index_demo', 'pages_demo');

        foreach ($indexs as $key => $index) {

            if(\RES::indices()->exists(['index' => $index])) {

                $response = \RES::indices()->delete(['index' => $index]);
            }   
        }

        $this->info('Success!');
    }
}
