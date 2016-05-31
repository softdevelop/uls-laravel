<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\PlatformModel;
use Rowboat\DatabaseManagement\Models\LaserModel;
use Rowboat\DatabaseManagement\Models\CutLaserModel;
use Rowboat\DatabaseManagement\Models\PowerModel;
use Rowboat\DatabaseManagement\Models\PlatformLaserModel;
class ImportPlatformLaser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform_laser:import_platform_laser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Platform Laser.';

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
        $this->info('Start platform laser !!!');

        $path =base_path();
        
        \Excel::load($path.'/platform_laser.xlsx', function($reader) use (&$isError) {
            $rows = $reader->get()->toArray();
            $litlimit =[];
            foreach ($rows as $key => $row) {
                if(empty($row['value'])) continue;
                $cutAndPower = explode(',', $row['value']);
                $textPower = explode(' ',$cutAndPower[0]);
                $textCut = explode(' ',$cutAndPower[1]);
                if(empty($textPower[1])) continue;
                if(empty($textCut[1])) continue;
                $platformModel = new PlatformModel();
                $platform = $platformModel->where('name',$row['platform'])->first();
                if(empty($platform)) continue;
                $laser = LaserModel::where('name',$row['laser'])->first(); 
                if(empty($laser)) continue;
                $platFormLaser = PlatformLaserModel::where('cut_laser',$textCut[1])
                                    ->where('power',intval(str_replace("W","",$textPower[1])))
                                    ->where('id_laser',$laser->id)
                                    ->where('id_platform',$platform->id)
                                    ->where('type',$textPower[0])->first();
                if(!empty($platFormLaser)) continue;
                $data = [];
                $data['cut_laser'] = $textCut[1];
                $data['power'] = intval(str_replace("W","",$textPower[1]));
                $data['id_laser'] =  $laser->id;
                $data['id_platform'] =  $platform->id;
                $data['type'] =  $textPower[0];
                $platformLaserModel = new PlatformLaserModel();
                $platformLaserModel->create($data);
                   
            }
        });

        $this->info('end !!!');
    }
}
