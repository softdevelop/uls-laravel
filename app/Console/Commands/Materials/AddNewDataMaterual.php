<?php

namespace App\Console\Commands\Materials;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\MaterialModel;
use Rowboat\DatabaseManagement\Models\MaterialContentModel;
use Rowboat\DatabaseManagement\Models\CategoriesModel;
use Rowboat\DatabaseManagement\Models\PlatformModel;
class AddNewDataMaterual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:add_new_data_materual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add New Data Materual.';

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
        $this->info('Start create marterial !!!');
        $path =base_path();
     
        $firstCategory = CategoriesModel::first();
        if(!empty($firstCategory)){

            \Excel::load($path.'/data_new_material.xlsx', function($reader) use (&$isError,$firstCategory) {
                $rows = $reader->get()->toArray();
                foreach ($rows as $key => $row) {
                        if(empty($row['materialid'])) continue;
                        $category = CategoriesModel::find($row['parentcategoryid']);
                        if(empty($category)){
                            $category  = $firstCategory; 
                        }
                        $data = [];

                        $materialModel = new MaterialModel();
                        $material = $materialModel->find($row['materialid']);

                        if(!empty($material)){
                            $material->category_id = $category->id;
                            $material->name = $row['materialname'];
                            $material->ancestor_ids = $material->id .",".$category->ancestor_ids;
                            $material->save();
                        } else {
                            
                            $materialModel->incrementing = false;
                            $materialModel->category_id = $category->id;
                            $materialModel->name = $row['materialname'];
                            $materialModel->id = $row['materialid'];
                            $materialModel->ancestor_ids = $row['materialid'] .",".$category->ancestor_ids;
                            $materialModel->save();
                        }
                        if(!empty($materialModel)||!empty($material)){
                            $dataContent = [];
                            $dataContent['engrave_mark_recommended_power'] =  $row['engravemarkrecommendedpower'];
                            $dataContent['min_thickness'] =  $row['minthickness'];
                            $dataContent['power_at_min_thickness'] =  $row['poweratminthickness'];
                            $dataContent['max_thickness'] =  $row['maxthickness'];
                            $dataContent['power_at_max_thickness'] =  $row['poweratmaxthickness'];
                            $dataContent['cut'] = $row['canbecut']?$row['canbecut']:0;
                            $dataContent['laser_type'] = $row['lasertype'];
                              /*  dd($row['lasertype']);*/
                            $dataContent['fixed_thickness'] = $row['fixedthickness']==null?false:$row['fixedthickness'];
                            $dataContent['can_be_rastered'] = $row['canberastered']==null?false:$row['canberastered'];
                            if(!empty($material)){
                                $material->materialContent()->update($dataContent);
                            } else {
                                $materialModel->materialContent()->create($dataContent);
                            }
                        }
                }
            });
        }

        $this->info('end !!!');
    }
    public function orderBy($data, $field)
    {
        $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
        usort($data, create_function('$a,$b', $code));
        return $data;
    }
}
