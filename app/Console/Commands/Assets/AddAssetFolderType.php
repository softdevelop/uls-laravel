<?php

namespace App\Console\Commands\Assets;

use Illuminate\Console\Command;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFolderModelMongo;

class AddAssetFolderType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:add_asset_folder_type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Asset Folder Type.';

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
        $folderRootAsset = $folderAsset->where('name', 'Assets')->where('parent_id', '0')->first();
        if (!empty($folderRootAsset)) {
            $folderImage = $folderAsset->where('name', 'images')->where('parent_id', $folderRootAsset->_id)->count();
            if (!$folderImage) {
                $createFolderImage = $folderAsset->create(['name' => 'images', 'parent_id' => $folderRootAsset->_id]);
            }
            $folderCss = $folderAsset->where('name', 'css')->where('parent_id', $folderRootAsset->_id)->count();
            if (!$folderCss) {
                $createFolderCss = $folderAsset->create(['name' => 'css', 'parent_id' => $folderRootAsset->_id]);
            }
            $folderJs = $folderAsset->where('name', 'js')->where('parent_id', $folderRootAsset->_id)->count();
            if (!$folderJs) {
                $createFolderJs = $folderAsset->create(['name' => 'js', 'parent_id' => $folderRootAsset->_id]);
            }
            $folderVideo = $folderAsset->where('name', 'video')->where('parent_id', $folderRootAsset->_id)->count();
            if (!$folderVideo) {
                $createFolderVideo = $folderAsset->create(['name' => 'video', 'parent_id' => $folderRootAsset->_id]);
            }
            $folderPDF = $folderAsset->where('name', 'pdf')->where('parent_id', $folderRootAsset->_id)->count();
            if (!$folderPDF) {
                $createFolderPDF = $folderAsset->create(['name' => 'pdf', 'parent_id' => $folderRootAsset->_id]);
            }
            $folderOther = $folderAsset->where('name', 'other')->where('parent_id', $folderRootAsset->_id)->count();
            if (!$folderOther) {
                $createFolderOther = $folderAsset->create(['name' => 'other', 'parent_id' => $folderRootAsset->_id]);
            }
        }
        $this->info('Success!');

    }
}
