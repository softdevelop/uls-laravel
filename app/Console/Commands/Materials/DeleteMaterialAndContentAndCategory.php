<?php

namespace App\Console\Commands\Materials;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\DatabaseManagement\Models\MaterialContentModel;
use Rowboat\DatabaseManagement\Models\MaterialModel;
use Rowboat\DatabaseManagement\Models\CategoriesModel;
class DeleteMaterialAndContentAndCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:delete_material_and_content_and_category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Material And Content And Category.';

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
        $materialModel = new MaterialModel();
        $marterials = $materialModel::all();
        foreach ($marterials as $key => $marterial) {
            $marterial->delete();
            $materialModel->materialContent()->delete();
        }
        $categories = CategoriesModel::all();
        foreach ($categories as $key => $category) {
            $category->delete();
        }
        $this->info('Success!');
    }
}
