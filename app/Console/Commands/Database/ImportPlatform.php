<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\PlatformModel;
class ImportPlatform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:import_platform';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add data platform.';

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

        $path =base_path();
        
        \Excel::load($path.'/platformData.xlsx', function($reader) use (&$isError) {
            $rows = $reader->get()->toArray();
            $litlimit =[];
            foreach ($rows as $key => $row) {
                if($row['platform_name'] ==null ||empty($row['platform_name']) ) continue;
                $platformModel = new PlatformModel();
                $platform = $platformModel->where('name',$row['platform_name'])->first();
               
                if(empty($platform)){
                    $data = [];
                    if($row['fiber'] == "YES" ){
                        $row['fiber'] = true;
                    } else {
                        $row['fiber'] = false;
                    }
                    if($row['width_exceptions_for_pass_through'] == "YES" ){
                        $row['width_exceptions_for_pass_through'] = true;
                    } else {
                        $row['width_exceptions_for_pass_through'] = false;
                    }
                    $data['name'] =  $row['platform_name'];
                    $data['fiber'] =  $row['fiber'];
                    $data['width'] =  $row['platform_width'];
                    $data['height'] =  $row['platform_height'];
                    $data['depth'] =  $row['platform_depth'];
                    $data['width_exceptions'] =  $row['width_exceptions_for_pass_through'];
                    $data['max_co2_lsrpwr'] =  $row['max_co2_laser_power'];
                    $data['productivity'] =  $row['productivity'] == null?false:$row['productivity'];
                    $data['dual_laser'] =  $row['dual_laser']== null?false:$row['dual_laser'];
                    $data['multiple_laser'] =  $row['multiple_laser']== null?false:$row['multiple_laser'];
                    $platformModel->create($data);
                   
                }
            }
        });

        $this->info('end !!!');
    }
}
