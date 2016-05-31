<?php

namespace App\Console\Commands\Materials;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\MaterialModel;
use Rowboat\DatabaseManagement\Models\MaterialContentModel;
use Rowboat\DatabaseManagement\Models\CategoriesModel;
class AddDataCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:add_database_category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add database category.';

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
        \Excel::load($path.'/category.xlsx', function($reader) use (&$isError) {
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
        $this->info('end !!!');
    }
    public function orderBy($data, $field)
    {
        $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
        usort($data, create_function('$a,$b', $code));
        return $data;
    }
}
