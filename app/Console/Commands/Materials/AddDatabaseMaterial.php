<?php

namespace App\Console\Commands\Materials;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\MaterialModel;
use Rowboat\DatabaseManagement\Models\MaterialContentModel;
use Rowboat\DatabaseManagement\Models\CategoriesModel;
class AddDatabaseMaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:add_database_material';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add database material.';

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
        $this->info('Start create category !!!');

        $path =base_path();
        $filenameMaterial = 'Materials';
        $filenameMCategory = 'ConfiguratorTable';
        $materialModel = new MaterialModel();
        $content = new MaterialContentModel();
        
        \Excel::load($path.'/'.$filenameMCategory.'.xlsx', function($reader) use (&$isError) {
            $rows = $reader->get()->toArray();
            $rows = $this->orderBy($rows,'categoryid');
            $litlimit =[];
            foreach ($rows as $key => $row) {
                $category = CategoriesModel::find($row['categoryid']);
                $parentCategory = CategoriesModel::find($row['parentcategoryid']);
                if(empty($parentCategory) && $row['parentcategoryid'] !=0){
                    $litlimit[$row['parentcategoryid']][] = $row;
                    continue;
                }
                if(empty($category)){
                    $data = [];
                    $data['parent_id'] =  $row['parentcategoryid'];
                    $data['name'] =  $row['categoryname'];
                    $data['id'] =  $row['categoryid'];
                    $categoriesModel = new CategoriesModel();
                    $categoriesModel->incrementing = false;
                    $categoriesModel->parent_id = $row['parentcategoryid'];
                    $categoriesModel->name = $row['categoryname'];
                    $categoriesModel->id = $row['categoryid'];
                    $categoriesModel->save();
                    // $newCategory = $categoriesModel->create($data);
                    if(empty($parentCategory)){
                        $categoriesModel->ancestor_ids = $row['categoryid'] .',0';
                    } else {
                        $categoriesModel->ancestor_ids = $row['categoryid'] .",".$parentCategory->ancestor_ids;
                    }
                    // $newCategory->id =  $row['categoryid'];
                    $categoriesModel->save();

                    if(!empty($litlimit[$categoriesModel->id])){
                        foreach ($litlimit[$categoriesModel->id] as $key1 => $valueLimit) {
                            $data = [];
                            $categoriesModel = new CategoriesModel();
                            $categoriesModel->incrementing = false;
                            $categoriesModel->incrementing = false;
                            $categoriesModel->parent_id = $valueLimit['parentcategoryid'];
                            $categoriesModel->name = $valueLimit['categoryname'];
                            $categoriesModel->id = $valueLimit['categoryid'];
                            $categoriesModel->save();
                            $categoriesModel->ancestor_ids = $valueLimit['categoryid'] .",".$categoriesModel->ancestor_ids;

                            $categoriesModel->save();
                            unset($litlimit[$categoriesModel->id][$key1]);
                        }
                    }
                }
            }
        });
        $this->info('Start create marterial !!!');
        \Excel::load($path.'/'.$filenameMaterial.'.xlsx', function($reader) use (&$isError, $content) {
            $rows = $reader->get()->toArray();
            $rows = $this->orderBy($rows,'materialid');
            foreach ($rows as $key => $row) {
                $marterial = MaterialModel::find($row['materialid']);
                $category = CategoriesModel::find($row['parentcategoryid']);
                if(!empty($category) && empty($marterial)){
                    $data = [];

                    $materialModel = new MaterialModel();

                    $materialModel->incrementing = false;
                    $materialModel->category_id = $row['parentcategoryid'];
                    $materialModel->name = $row['materialname'];
                    $materialModel->id = $row['materialid'];

                    $materialModel->ancestor_ids = $row['materialid'] .",".$category->ancestor_ids;

                    $materialModel->save();
                    if(!empty($materialModel)){
                        $dataContent = [];
                        $dataContent['engrave_mark'] = 0;
                        $dataContent['engrave_mark_recommended_power'] =  $row['engravemarkrecommendedpower'];
                        $dataContent['min_thickness'] =  $row['minthickness'];
                        $dataContent['power_at_min_thickness'] =  $row['poweratminthickness'];
                        $dataContent['max_thickness'] =  $row['maxthickness'];
                        $dataContent['power_at_max_thickness'] =  $row['poweratmaxthickness'];
                        $dataContent['wave_length'] =  $row['wavelength'];
                        $dataContent['cut'] =  0;
                        $dataContent['width'] =  0;
                        $dataContent['height'] =  0;
                        $dataContent['depth'] =  0;
                        $materialModel->materialContent()->create($dataContent);
                    }
                }
            }
        });

        $this->info('end !!!');
    }
    public function orderBy($data, $field)
    {
        $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
        usort($data, create_function('$a,$b', $code));
        return $data;
    }
}
