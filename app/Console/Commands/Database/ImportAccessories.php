<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;

use Rowboat\DatabaseManagement\Models\CategoriesModel;
use Rowboat\DatabaseManagement\Models\AccessoriesModel;
use Rowboat\DatabaseManagement\Models\PlatformModel;
class ImportAccessories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accessories:import_accessories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Accessories.';

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
        $this->info('Start platform !!!');

        $accessoriesModel = new AccessoriesModel();
        $accessoriesModel->delete();

        CategoriesModel::where('type', 'accessories')->delete();
        /*  $platformSuperspeed = PlatformModel::where('name','PLS6.15D w/Superspeed')->first();
        if(empty($platformSuperspeed)){
            PlatformModel::create(['name'=>'PLS6.15D w/Superspeed','fiber'=>false,'width'=>0,'height'=>0,'depth' => 0,'width_exceptions'=>false,'max_co2_lsrpwr'=>0,'productivity'=>false,'dual_laser'=>false,'multiple_laser'=>false]);
        }*/
        $listPlatform = PlatformModel::lists('id','name');
        $plaformMap = [];
        foreach ($listPlatform as $key => $platform) {
            $plaformMap[strtolower(preg_replace('/([._ ])/', '',$key))] = $platform;
        }
        $path = base_path();
        
        \Excel::load($path.'/options_benefits_revised_052116.xlsx', function($reader) use (&$isError,$plaformMap)  {
            $rows = $reader->get()->toArray();
            $cetegoryId = 0;
            foreach ($rows as $key => $row) {
                if (is_null($row['vls230']) && is_null($row['vls350'])) {
                    if(is_null($row['accessory'] )) continue ;
                    $category = CategoriesModel::create(['name' => $row['accessory'] , 'type' => 'accessories','description'=>$row['description']]);
                    $cetegoryId = $category->id;
                    continue;
                }
                $benefits ='';
                $length =count(explode('*', $row['benefits']));
                foreach (explode('*', $row['benefits']) as $keybf => $valuebf) {
                    if(!empty($valuebf)){
                        $benefits = $benefits .'<li>' .$valuebf.'</li>';
                    }
                   
                }
                $row['benefits'] =$benefits;
                $accessory =   AccessoriesModel::create(['name' => $row['accessory'], 
                                         'dependencies' => $row['dependencies'],
                                         'description' => $row['description'],
                                         'benefits' => $row['benefits'],
                                         'uuf' => $row['uuf'],
                                         'category_id' => $cetegoryId
                                         ]);
                $tmp= [];
                if($row['vls230'] !="N/A"){

                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','vls230'))])){
                       $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','vls230'))]] =['state'=>$row['vls230']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['vls350'] !='N/A' ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','vls350'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','vls350'))]] =['state'=>$row['vls350']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['vls460'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','vls460'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','vls460'))]] =['state'=>$row['vls460']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['vls360'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','vls360'))])){
        
                       $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','vls360'))]] =['state'=>$row['vls360']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['vls660'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','vls660'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','vls660'))]] =['state'=>$row['vls660']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['pls475'] !="N/A"){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','pls475'))])){
        
                       $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','pls475'))]] =['state'=>$row['pls475']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['pls675'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','pls675'))])){
        
                       $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','pls675'))]] =['state'=>$row['pls675']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['pls6150d'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','pls6150d'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','pls6150d'))]] =['state'=>$row['pls6150d']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                /*  if($row['pls615d_wsuperspeed'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','pls615d_wsuperspeed'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','pls615d_wsuperspeed'))]] =['state'=>$row['pls615d_wsuperspeed']];
                       $accessory->platform()->sync($tmp);

                    }
                }*/
                if($row['pls6mw'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','pls6mw'))])){
        
                       $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','pls6mw'))]] =['state'=>$row['pls6mw']];
                       $accessory->platform()->sync($tmp);
                    }
                }
                if($row['ils975'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','ils975'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','ils975'))]] =['state'=>$row['ils975']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['ils1275'] !="N/A"){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','ils1275'))])){
        
                      $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','ils1275'))]] =['state'=>$row['ils1275']];
                       $accessory->platform()->sync($tmp);

                    }
                }
                if($row['xls10150d'] !="N/A" ){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','xls10150d'))])){
        
                       $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','xls10150d'))]] =['state'=>$row['xls10150d']];
                       $accessory->platform()->sync($tmp);
                    }
                }
                if($row['xls10mwh'] !="N/A"){
                    if(!empty($plaformMap[strtolower(preg_replace('/([._ ])/', '','xls10mwh'))])){
        
                        $tmp[$plaformMap[strtolower(preg_replace('/([._ ])/', '','xls10mwh'))]] =['state'=>$row['xls10mwh']];
                        $accessory->platform()->sync($tmp);
                    }
                }
            }

        });
        PlatformModel::whereNull('name')->delete();


        $this->info('end !!!');

    }
}
