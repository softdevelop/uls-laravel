<?php namespace App\Console\Commands\DataOption;

use Illuminate\Console\Command;
use Rowboat\DataOption\Models\Mongo\DataOptionMongo;

class AddNewDataOption extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataOption:add_new_data_option';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new data option';

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
        $dataOptionModelMongo = new DataOptionMongo;
        $this->info('Start...');

        $alias = str_replace(" ", "_", strtolower('Asset File Size'));
        $dataOptionExit = $dataOptionModelMongo->where('alias', $alias)->count();
        if ($dataOptionExit == 0) {

            $dataOptionModelMongo->label = 'Asset File Size';
            $dataOptionModelMongo->alias = $alias;
            $dataOptionModelMongo->number_option = 4;
            $dataOptionModelMongo->save();
            $dataOptions = [
                '0' => [
                    'name' => '500x500'
                ],
                '1' => [
                    'name' => '400x400'
                ],
                '2' => [
                    'name' => '300x300'
                ],
                '3' => [
                    'name' => '200x200'
                ]
            ];

            foreach($dataOptions as $key => $value){
                $dataOptionModelMongo->option()->create(
                        [
                            'name'=>$value['name'],
                            'alias' => str_replace(" ","_",strtolower($value['name']))
                        ]
                    );
            }
        }

        $this->info('Success!');
    }
}
