<?php

namespace App\Console\Commands\Pages;

use Illuminate\Console\Command;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\CmsDataModelMongo;

class UpdateIndexDataMultiPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:update_index_data_multi_pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Index Data Multi Pages';

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

        $dataPages = CmsDataModelMongo::all();

        foreach ($dataPages as $value) {

            $tmpData =  $value['data'];

            foreach ($tmpData['fields'] as $key => &$datas) {
                
                $tmpDataMulti = [];

                if(empty($datas)) continue;
                if(is_array($datas)) {

                    foreach ($datas as $data) {
                        $tmpDataMulti[] = $data;
         
                    }

                    if(!empty($tmpDataMulti))
                    $datas = $tmpDataMulti;

                }
            }

            $value['data'] = $tmpData;                
            $value->save();
        }

        $this->info('Success!');

    }

    function d() {

        echo '<pre>'; print_r($data); echo '</pre>';

    }
}
