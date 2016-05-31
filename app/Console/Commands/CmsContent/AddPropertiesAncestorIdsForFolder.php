<?php

namespace App\Console\Commands\CmsContent;

use Illuminate\Console\Command;

use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFolderModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateFolderModelMongo;

class AddPropertiesAncestorIdsForFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:add_properties_ancestor_ids_for_folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add properties ancestor_ids for folder.';

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
        $this->info('Start add properties ancestor_ids for folder ...');

        $this->models = [];
        $this->blockFolderModel = new BlocksFolderModelMongo;
        $this->assetFolderModel = new AssetsFolderModelMongo;
        $this->pageFolderModel = new PageModelMongo;
        $this->templateFolderModel = new TemplateFolderModelMongo;
        $this->models = [
            $this->blockFolderModel, $this->assetFolderModel, 
            $this->pageFolderModel, $this->templateFolderModel
        ];

        foreach ($this->models as $model) {
            // Get all folders block
            $folders = $model->all();    

            // Each block folder
            foreach ($folders as $key => &$folder) {
                $folder->timestamps = false;
                $ancestor_ids = [$folder->_id];

                $folder->ancestor_ids = [];
                // Call function 
                $this->recursiveAddPropertiesAncestorIds($model, $folder, $ancestor_ids);
                // Set ancestorIds for folder
                $folder->ancestor_ids = $ancestor_ids;
                // Save folder
                $folder->save();
            }
        }

        $this->info('Success!');

    }

    /**
     * [recursiveAddPropertiesAncestorIds description]
     * @param  Model  $model         Model
     * @param  Object $folder        Object folder
     * @param  Array  &$ancestor_ids Array content ancestor id 
     * @return Void                
     */
    public function recursiveAddPropertiesAncestorIds($model, $folder, &$ancestor_ids) 
    {
        if (isset($folder->parent_id)) {    
            // Push block id to parentIds
            array_push($ancestor_ids, $folder->parent_id);
            // Get folder block
            $itemFolder = $model->find($folder->parent_id);
            // Call it self
            if (isset($itemFolder)) {
                self::recursiveAddPropertiesAncestorIds($model, $itemFolder, $ancestor_ids);
            }
        }
    }
}
