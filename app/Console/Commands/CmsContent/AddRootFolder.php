<?php

namespace App\Console\Commands\CmsContent;

use Illuminate\Console\Command;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFolderModelMongo;
use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateFolderModelMongo;
use Rowboat\DatabaseManagement\Models\Mongo\DatabaseModelMongo;

class AddRootFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:add_root_folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Root Folder.';

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

        $folderAsset = new AssetsFolderModelMongo();
        $foldersAsset = $folderAsset->where('parent_id', '0')->get();
        $folderRootAsset = $folderAsset->where('name', 'Assets')->where('parent_id', '0')->count();
        if (!$folderRootAsset) {
            $createRootAsset = $folderAsset->create(['name' => 'Assets', 'parent_id' => '0']);
            foreach ($foldersAsset as $key => $value) {
                $value->update(['parent_id' => $createRootAsset->_id]);
            }

        }
        $folderBlock = new BlocksFolderModelMongo();
        $foldersBlock = $folderBlock->where('parent_id', '0')->get();
        $folderRootBlock = $folderBlock->where('name', 'Blocks')->where('parent_id', '0')->count();
        if (!$folderRootBlock) {
            $createRootBlock = $folderBlock->create(['name' => 'Blocks', 'parent_id' => '0']);
            foreach ($foldersBlock as $key => $value) {
                $value->update(['parent_id' => $createRootBlock->_id]);
            }

        }
        $folderTemplate = new TemplateFolderModelMongo();
        $foldersTemplate = $folderTemplate->where('parent_id', '0')->get();
        $folderRootTemplate = $folderTemplate->where('name', 'Templates')->where('parent_id', '0')->count();
        if (!$folderRootTemplate) {
            $createRootTemplate = $folderTemplate->create(['name' => 'Templates', 'parent_id' => '0']);
            foreach ($foldersTemplate as $key => $value) {
                $value->update(['parent_id' => $createRootTemplate->_id]);
            }

        }
        $pageModel = new PageModelMongo();
        $pages = $pageModel->where('parent_id', '0')->get();
        $pageRoot = $pageModel->where('name', 'Pages')->where('parent_id', '0')->count();
        if (!$pageRoot) {
            $createPageRoot = $pageModel->create(['name' => 'Pages', 'parent_id' => '0']);
            foreach ($pages as $key => $value) {
                $value->update(['parent_id' => $createPageRoot->_id]);
            }

        }

        // $databaseModel = new DatabaseModelMongo();
        // $databases = $databaseModel->where('parent_id', '0')->get();
        // $databaseRoot = $databaseModel->where('name', 'Database')->where('parent_id', '0')->count();
        // if (!$databaseRoot) {
        //     $createDatabaseRoot = $databaseModel->create(['name' => 'Database', 'parent_id' => '0']);
        //     foreach ($databases as $key => $value) {
        //         $value->update(['parent_id' => $createDatabaseRoot->_id]);
        //     }
        // }

        $this->info('Success!');

    }
}
