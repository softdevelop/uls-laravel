<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\LaserModel;
class ImportLaser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laser:import_laser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Laser.';

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
        $this->info('Start laser !!!');
        $array =['Laser 1','Laser 2','Laser 3'];
        foreach ($array as $key => $value) {
            $laserModel = new LaserModel();
            $laser = $laserModel->where('name',$value)->first();
            if(empty($laser)){
                $laserModel->Create(['name'=>$value]);
            }
        }
        $this->info('end !!!');
    }
}
