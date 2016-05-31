<?php namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Rowboat\DatabaseManagement\Models\Mongo\DatabaseModelMongo;

class AddValueDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:add-value-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Value Demo: ';

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
        $this->info('Start...');

        $databaseModelMongoObj = DatabaseModelMongo::all();
        foreach ($databaseModelMongoObj as $key => $item) {
            $data['default'] = true;
            $data['name'] = 'products';
            $data['query'] = [["display_field" => "title", "select_field" => "id", "query" => "id=?"], ["display_field" => "title1", "select_field" => "laser_platform", "query" => "laser_platform=?"]];
            $item->views()->create($data);
        }

        $this->info('Success!');

    }
}
