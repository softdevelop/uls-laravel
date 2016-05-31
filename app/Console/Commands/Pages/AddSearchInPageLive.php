<?php

namespace App\Console\Commands\Pages;

use Illuminate\Console\Command;
use Rowboat\ContentManagement\Services\PagesService;
use Rowboat\ContentManagement\Services\DataService;
use Rowboat\TemplateContentManager\Models\Mongo\ContentTemplateModelMongo;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFileModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;

class AddSearchInPageLive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @author Minh than <than@httsolution.com>
     *
     * command php artisan cms:add_search_page_live
     * 
     * @var string
     */
    protected $signature = 'cms:add_search_page_live';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add search page live';

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
        $this->info('Start add search page live...');

        $contents = ContentModelMongo::all();

        $indexDemo = env('es_index_demo', 'pages_demo');
         
        foreach ($contents as $contentObject) {

            if(empty($contentObject->template_id)) continue;

            if($contentObject->url == 'search-result') continue;
            // get html in current content page
            $html = PagesService::getViewPage($contentObject);

            //get data in content page
            $dataPage = DataService::getDataOfCurrentPage($contentObject->_id);

            \EsService::updateElasticSearch($indexDemo, $contentObject, $dataPage['fields'], $html);

        }

        $indexLive = env('es_index', 'pages_dev');

        $contents = ContentModelMongo::where('status', 'live')->get();

        foreach ($contents as $key => $contentObject) {

            if(empty($contentObject->template_id)) continue;

            if($contentObject->url == 'search-result') continue;
            // get html in current content page
            $html = PagesService::getViewPage($contentObject);

            //get data in content page
            $dataPage = DataService::getDataOfCurrentPage($contentObject->_id);

            \EsService::updateElasticSearch($indexLive, $contentObject, $dataPage['fields'], $html);

        }

        $this->info('Success!');
    }
}
