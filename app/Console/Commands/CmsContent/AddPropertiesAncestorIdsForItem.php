<?php

namespace App\Console\Commands\CmsContent;

use Illuminate\Console\Command;

use Rowboat\BlocksManagement\Models\Mongo\BlocksModelMongo;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFileModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateContentManagerModel;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFolderModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateFolderModelMongo;

class AddPropertiesAncestorIdsForItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:add_properties_ancestor_ids_for_item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add properties ancestor_ids for item.';

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
        $this->info('Start add properties ancestor_ids for item ...');

        $this->models = [];
        $this->blockModel = new BlocksModelMongo;
        $this->assetModel = new AssetsFileModelMongo;
        $this->templateModel = new TemplateContentManagerModel;
        $this->models = [
            $this->blockModel, $this->assetModel, $this->templateModel
        ];

        foreach ($this->models as $model) {

            // Get all items
            $items = $model->all();    

            // Each item
            foreach ($items as $key => &$item) {
                $item->timestamps = false;
                $ancestor_ids = [];

                $item->ancestor_ids = [];

                // Call function 
                $this->recursiveAddPropertiesAncestorIds($model, $item, $ancestor_ids);
                // Set ancestorIds for item
                $item->ancestor_ids = $ancestor_ids;
                // $item->timestamps  = false;
                // Save item
                $item->save();
            }
        }

        $this->info('Success!');

    }

    /**
     * [recursiveAddPropertiesAncestorIds description]
     * @param  Model  $model         Model
     * @param  Object $item          Object template, asset or block
     * @param  Array  &$ancestor_ids Array contain ancestor ids
     * @return Void                
     */
    public function recursiveAddPropertiesAncestorIds($model, $item, &$ancestor_ids) 
    {
        if (isset($item->folder_id)) {   
            // Push block id to parentIds
            array_push($ancestor_ids, $item->folder_id);      
            // Get folder 
            if ($item->cmsBlockFolder) {
                $this->recursiveAddPropertiesAncestorForderIds(new BlocksFolderModelMongo, $item->cmsBlockFolder, $ancestor_ids);
            }
            if ($item->cmsAssetFolder) {
                $this->recursiveAddPropertiesAncestorForderIds(new AssetsFolderModelMongo, $item->cmsAssetFolder, $ancestor_ids);
            }
            if ($item->cmsTemplateFolder) {
                $this->recursiveAddPropertiesAncestorForderIds(new TemplateFolderModelMongo, $item->cmsTemplateFolder, $ancestor_ids);
            }
        }
    }
 
    /**
     * [recursiveAddPropertiesAncestorForderIds description]
     * @param  Model  $model         Model
     * @param  Object $folder        Object folder
     * @param  Array  &$ancestor_ids Array contain ancestor ids
     * @return Void                
     */
    public function recursiveAddPropertiesAncestorForderIds($model, $folder, &$ancestor_ids) 
    {
        if (isset($folder->parent_id)) {
            // Push block id to parentIds
            array_push($ancestor_ids, $folder->parent_id);
            // Get folder block
            $itemFolder = $model->find($folder->parent_id);
            // Call it self
            if (isset($itemFolder)) {
                self::recursiveAddPropertiesAncestorForderIds($model, $itemFolder, $ancestor_ids);
            }
        }
    }
}
